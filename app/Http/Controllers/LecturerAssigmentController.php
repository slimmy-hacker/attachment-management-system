<?php

namespace App\Http\Controllers;

use App\Models\AdministrativeUnit;
use App\Models\Attachment;
use App\Models\AttachmentLecturer;
use App\Models\AttachmentStudent;
use App\Models\LecturerAssigment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class LecturerAssigmentController extends Controller
{ private $specialClusters = []; 
    
    public function index(Request $request)
{
    if ($request->ajax()) {
        $data = AttachmentStudent::whereNotNull('company_id')
            ->with([
                'attachment',
                'student.user',
                'student.program.parent', 
                'attachmentLecturer.lecturer.user',
                'company.town'
            ]);

        if (!empty($request->attachment_id)) {
            $data->where('attachment_id', $request->attachment_id);
        }

        if (!empty($request->department_id)) {
            $data->whereHas('student.program.parent', function ($q) use ($request) {
                $q->where('id', $request->department_id);
            });
        }

      
        $students = $data->get();
        
        
        $groupedData = [];
        $counter = 1;
        
        
        $lecturerGroups = [];
        foreach ($students as $student) {
            
            $lecturerName = 'Unknown';
            if ($student->attachmentLecturer && 
                $student->attachmentLecturer->lecturer && 
                $student->attachmentLecturer->lecturer->user) {
                $lecturerName = $student->attachmentLecturer->lecturer->user->name;
            } else {
                $lecturerName = '<span class="badge badge-warning">Not Assigned</span>';
            }
            
            if (!isset($lecturerGroups[$lecturerName])) {
                $lecturerGroups[$lecturerName] = [];
            }
            $lecturerGroups[$lecturerName][] = $student;
        }
        
        
        uksort($lecturerGroups, function($a, $b) {
            if ($a === '<span class="badge badge-warning">Not Assigned</span>') return 1;
            if ($b === '<span class="badge badge-warning">Not Assigned</span>') return -1;
            return strcmp($a, $b);
        });
        
        
        foreach ($lecturerGroups as $lecturerName => $students) {
            
            usort($students, function($a, $b) {
                return strcmp($a->student->user->name ?? '', $b->student->user->name ?? '');
            });
            
            foreach ($students as $student) {
                $groupedData[] = [
                    'DT_RowIndex' => $counter++,
                    'attachment' => $student->attachment->name ?? '-',
                    'name' => $student->student->user->name ?? '-',
                    'reg_no' => $student->student->reg_no ?? '-',
                    'department' => $student->student->program->parent->name ?? '-',
                    'lecturer' => $lecturerName,
                    'company' => $student->company->name ?? '-',
                    'town' => $student->company->town->name ?? '-',
                    'phone_number' => $student->student->phone_number ?? '-'
                ];
            }
        }

        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => count($groupedData),
            'recordsFiltered' => count($groupedData),
            'data' => $groupedData
        ]);
    }

    $attachments = Attachment::select('id', 'name')->orderBy('created_at', 'desc')->get();
    $departments = AdministrativeUnit::where('level', 2)->get();

    return view('admin.lecturer_assignment', compact('attachments', 'departments'));
}
public function generateDraft(Request $request)
{
    $request->validate([
        'department_id' => 'required|exists:administrative_units,id',
        'attachment_id' => 'required|exists:attachments,id',
    ]);

    $students = AttachmentStudent::with(['company.town', 'student.program.parent'])
        ->where('attachment_id', $request->attachment_id)
        ->whereNotNull('company_id')
        ->whereHas('student.program.parent', fn($q) => $q->where('id', $request->department_id))
        ->get();

   
    $lecturers = AttachmentLecturer::with('lecturer.user')
        ->where([
            'attachment_id' => $request->attachment_id,
            'department_id' => $request->department_id
        ])
        ->get();

   
    $clusters = [
        'nairobi_metro' => ['cbd', 'upperhill', 'nairobi'],
        'nairobi_westlands' => ['Westlands', 'Parklands', 'Kilimani', 'Kileleshwa', 'Kangemi', 'Loresho'],
        'thika_road' => ['Thika', 'Makuyu', 'Ruiru', 'Juja', 'Limuru', 'Kiambu', 'Gikuyu'],
        'nakuru_cluster' => ['Nakuru', 'Naivasha', 'Nyahururu', 'Gilgil', 'Molo', 'Eldama Ravine', 'Ol Kalou', 'Rumuruti', 'nanyuki'],
        'north_rift_cluster' => ['Eldoret', 'Kitale', 'Iten', 'Tambach', 'Kapenguria', 'Burnt Forest', 'Kapsabet', 'Nandi Hills'],
        'western_cluster' => ['Kakamega', 'Mumias', 'Kisumu', 'Homa Bay', 'Muhoroni', 'Vihiga', 'Bungoma', 'Webuye', 'Kimilili', 'Malakisi', 'Busia', 'Malaba', 'Mbale', 'Siaya', 'Bondo', 'Ugunja', 'Ukwala', 'Yala', 'Nyamira', 'Nyansiongo', 'Migori', 'Rongo', 'Kisii'],
        'nyeri_mt_kenya_cluster' => ['Nyeri', 'Othaya'],
        'meru_embu_cluster' => ['Meru', 'Maua', 'Karatina', 'Chuka', 'Embu', 'Mwea', 'Sagana','kenol', 'Muranga', 'Maragua', 'Kangema', 'Runyenjes', 'Kerugoya', 'Kutus', 'Kirinyaga'],
        'coast_cluster' => ['Mombasa', 'Mtwapa', 'Kilifi', 'Malindi', 'Voi', 'Mariakani', 'Ukunda', 'Likoni', 'Nyali', 'Changamwe'],
        'mombasa_road_cluster' => ['Machakos', 'Kangundo-Tala', 'Matuu', 'Kitui', 'Mwingi', 'Makueni', 'Mombasa Road', 'Donholm', 'Eastleigh', 'Embakasi', 'Umoja', 'Athi River', 'Kitengela', 'Pipeline', 'South B', 'South C', 'Buruburu'],
        'kasarani_cluster' => ['kasarani', 'Roysambu', 'Githurai', 'Kahawa', 'Zimmerman', 'Muthaiga'],
        'kericho_south_rift_cluster' => ['Kericho', 'Litein', 'Kipkelion', 'Londiani', 'Bomet', 'Narok', 'Iten', 'Tambach', 'Nandi Hills', 'Kapsabet', 'Kitale', 'Kabarnet'],
        'frontier_cluster' => ['Garissa', 'Wajir', 'Mandera', 'Isiolo', 'Moyale', 'Lodwar', 'Kakuma', 'Maralal', 'Samburu'],
    ];

    
    $studentsById = [];
    $coastStudents = [];
    $frontierStudents = [];
    $nairobiMetroStudents = [];
    $nyeriStudents = [];
    $regularClusterStudents = [];
    $uncategorized = [];

    foreach ($students as $student) {
        if (!$student->company || !$student->company->town) {
            $uncategorized[] = $student->id;
            continue;
        }
        
        $townName = strtolower(trim($student->company->town->name));
        $townName = str_replace([' road', ' rd', ' street', ' st', ' avenue', ' ave', ' lane', ' ln'], '', $townName);
        $townName = trim($townName);
        
        $studentObj = (object) [
            'id' => $student->id,
            'company_id' => $student->company_id,
            'original_model' => $student
        ];
        
        $studentsById[$student->id] = $studentObj;
        
       
        $foundCluster = null;
        foreach ($clusters as $clusterName => $towns) {
            foreach ($towns as $town) {
                $searchTown = strtolower(trim($town));
                if (strpos($townName, $searchTown) !== false) {
                    $foundCluster = $clusterName;
                    break 2;
                }
            }
        }
        
        if (!$foundCluster) {
            
            $firstWord = explode(' ', $townName)[0];
            foreach ($clusters as $clusterName => $towns) {
                foreach ($towns as $town) {
                    if ($firstWord === strtolower(trim($town))) {
                        $foundCluster = $clusterName;
                        break 2;
                    }
                }
            }
        }
        
        if (!$foundCluster) {
            $uncategorized[] = $student->id;
            continue;
        }
        
        
        if ($foundCluster === 'coast_cluster') {
            $coastStudents[] = $student->id;
        } elseif ($foundCluster === 'frontier_cluster') {
            $frontierStudents[] = $student->id;
        } elseif ($foundCluster === 'nyeri_mt_kenya_cluster') {
            $nyeriStudents[] = $student->id;
        } elseif ($foundCluster === 'nairobi_metro') {
            $nairobiMetroStudents[] = $student->id;
            if (!isset($regularClusterStudents[$foundCluster])) {
                $regularClusterStudents[$foundCluster] = [];
            }
            $regularClusterStudents[$foundCluster][] = $student->id;
        } else {
            if (!isset($regularClusterStudents[$foundCluster])) {
                $regularClusterStudents[$foundCluster] = [];
            }
            $regularClusterStudents[$foundCluster][] = $student->id;
        }
    }

    
    $totalStudents = count($students);
    $totalLecturers = $lecturers->count();
    $AVERAGE = $totalStudents / $totalLecturers;
    $MIN_TARGET = max(1, (int) floor($AVERAGE) - 1);
    $MAX_TARGET = (int) ceil($AVERAGE) + 1;

    \Log::info("=== TARGETS ===");
    \Log::info("Total Students: $totalStudents");
    \Log::info("Total Lecturers: $totalLecturers");
    \Log::info("MIN Target: $MIN_TARGET");
    \Log::info("MAX Target: $MAX_TARGET");

    
    $assignments = [];
    $lecturerList = [];
    foreach ($lecturers as $lecturer) {
        $id = $lecturer->id;
        $lecturerList[] = $id;
        $assignments[$id] = [
            'id' => $id,
            'name' => $lecturer->lecturer->user->name ?? 'Unknown',
            'student_ids' => [],
            'count' => 0,
            'clusters' => [],
            'is_mombasa_road' => false,
            'is_westlands' => false,
            'is_kasarani' => false
        ];
    }

    $assignedIds = [];

    
    $coastLecturerId = null;
    if (!empty($coastStudents)) {
        $coastLecturerId = array_shift($lecturerList);
        $assignments[$coastLecturerId]['student_ids'] = $coastStudents;
        $assignments[$coastLecturerId]['count'] = count($coastStudents);
        $assignments[$coastLecturerId]['clusters'][] = 'coast_cluster';
        $assignedIds = array_merge($assignedIds, $coastStudents);
        \Log::info("✓ Coast: " . count($coastStudents) . " students to {$assignments[$coastLecturerId]['name']}");
    }

    
    \Log::info("=== DISTRIBUTING REGULAR CLUSTERS ===");
    
    $mombasaRoadLecturers = [];
    $westlandsLecturers = [];
    $kasaraniLecturers = [];
    
    
    shuffle($lecturerList);
    $queue = $lecturerList;
    
    foreach ($regularClusterStudents as $clusterName => $studentIds) {
        if ($clusterName === 'nairobi_metro') continue;
        if (empty($studentIds) || empty($queue)) continue;
        
        $clusterSize = count($studentIds);
        $neededLecturers = min(count($queue), ceil($clusterSize / $MIN_TARGET));
        
        \Log::info("{$clusterName}: {$clusterSize} students to {$neededLecturers} lecturers");
        
        $perLecturer = floor($clusterSize / $neededLecturers);
        $remainder = $clusterSize % $neededLecturers;
        
        $start = 0;
        for ($i = 0; $i < $neededLecturers; $i++) {
            if (empty($queue)) break;
            
            $lid = array_shift($queue);
            $extra = ($i < $remainder) ? 1 : 0;
            $takeCount = $perLecturer + $extra;
            
            $takeIds = array_slice($studentIds, $start, $takeCount);
            $start += $takeCount;
            
            $assignments[$lid]['student_ids'] = array_merge($assignments[$lid]['student_ids'], $takeIds);
            $assignments[$lid]['count'] += count($takeIds);
            $assignments[$lid]['clusters'][] = $clusterName;
            $assignedIds = array_merge($assignedIds, $takeIds);
            
            
            if ($clusterName === 'mombasa_road_cluster') {
                $mombasaRoadLecturers[] = $lid;
                $assignments[$lid]['is_mombasa_road'] = true;
            } elseif ($clusterName === 'nairobi_westlands') {
                $westlandsLecturers[] = $lid;
                $assignments[$lid]['is_westlands'] = true;
            } elseif ($clusterName === 'kasarani_cluster') {
                $kasaraniLecturers[] = $lid;
                $assignments[$lid]['is_kasarani'] = true;
            }
        }
    }

    if (!empty($frontierStudents) && !empty($mombasaRoadLecturers)) {
        $frontierIds = array_diff($frontierStudents, $assignedIds);
        
        if (!empty($frontierIds)) {
            \Log::info("=== ASSIGNING FRONTIER TO MOMBASA ROAD ===");
            
            $perLecturer = ceil(count($frontierIds) / count($mombasaRoadLecturers));
            $start = 0;
            $frontierList = array_values($frontierIds);
            
            foreach ($mombasaRoadLecturers as $lid) {
                if ($start >= count($frontierList)) break;
                
                $takeCount = min($perLecturer, count($frontierList) - $start);
                $takeIds = array_slice($frontierList, $start, $takeCount);
                $start += $takeCount;
                
                $assignments[$lid]['student_ids'] = array_merge($assignments[$lid]['student_ids'], $takeIds);
                $assignments[$lid]['count'] += count($takeIds);
                $assignments[$lid]['clusters'][] = 'frontier_cluster';
                $assignedIds = array_merge($assignedIds, $takeIds);
                
                \Log::info("  → {$assignments[$lid]['name']} got {$takeCount} frontier students");
            }
        }
    }

    if (!empty($nairobiMetroStudents)) {
        $metroIds = array_diff($nairobiMetroStudents, $assignedIds);
        $metroIds = array_values($metroIds);
        
        \Log::info("=== NAIROBI METRO DISTRIBUTION (" . count($metroIds) . " students) ===");
        
        if (!empty($metroIds)) {
            $start = 0;
            $totalMetro = count($metroIds);
            
            
            $emptyLecturers = [];
            foreach ($assignments as $lid => $ass) {
                if ($lid === $coastLecturerId) continue;
                if (empty($ass['clusters'])) {
                    $emptyLecturers[] = $lid;
                }
            }
            
            
            $pureClusters = min(floor($totalMetro / $MIN_TARGET), count($emptyLecturers));
            
            for ($i = 0; $i < $pureClusters; $i++) {
                $lid = $emptyLecturers[$i];
                $takeCount = $MIN_TARGET;
                $takeIds = array_slice($metroIds, $start, $takeCount);
                $start += $takeCount;
                
                $assignments[$lid]['student_ids'] = array_merge($assignments[$lid]['student_ids'], $takeIds);
                $assignments[$lid]['count'] += count($takeIds);
                $assignments[$lid]['clusters'][] = 'nairobi_metro';
                $assignedIds = array_merge($assignedIds, $takeIds);
                
                \Log::info("  → [PURE] {$assignments[$lid]['name']} got pure Nairobi Metro cluster");
            }
            
            
            if ($start < $totalMetro) {
                $remaining = array_slice($metroIds, $start);
                $specialLecturers = array_merge($mombasaRoadLecturers, $westlandsLecturers, $kasaraniLecturers);
                $specialLecturers = array_unique($specialLecturers);
                
                if (!empty($specialLecturers)) {
                    $perLecturer = ceil(count($remaining) / count($specialLecturers));
                    $remStart = 0;
                    
                    foreach ($specialLecturers as $lid) {
                        if ($remStart >= count($remaining)) break;
                        
                        $takeCount = min($perLecturer, count($remaining) - $remStart);
                        $takeIds = array_slice($remaining, $remStart, $takeCount);
                        $remStart += $takeCount;
                        
                        $assignments[$lid]['student_ids'] = array_merge($assignments[$lid]['student_ids'], $takeIds);
                        $assignments[$lid]['count'] += count($takeIds);
                        if (!in_array('nairobi_metro', $assignments[$lid]['clusters'])) {
                            $assignments[$lid]['clusters'][] = 'nairobi_metro';
                        }
                        $assignedIds = array_merge($assignedIds, $takeIds);
                    }
                    
                    $start = $totalMetro - (count($remaining) - $remStart);
                }
            }
            
            
            if ($start < $totalMetro) {
                $remaining = array_slice($metroIds, $start);
                $allLecturers = array_diff(array_keys($assignments), [$coastLecturerId]);
                
                foreach ($remaining as $sid) {
                    $lowestLid = null;
                    $lowestCount = PHP_INT_MAX;
                    
                    foreach ($allLecturers as $lid) {
                        if ($assignments[$lid]['count'] < $lowestCount) {
                            $lowestCount = $assignments[$lid]['count'];
                            $lowestLid = $lid;
                        }
                    }
                    
                    if ($lowestLid) {
                        $assignments[$lowestLid]['student_ids'][] = $sid;
                        $assignments[$lowestLid]['count']++;
                        $assignedIds[] = $sid;
                    }
                }
            }
        }


\Log::info("=== INTRA-CLUSTER OPTIMIZATION: MAXIMUM = " . ($MIN_TARGET + 2) . " ===");

$MAX_TARGET = $MIN_TARGET + 2; 
$lecturersByCluster = [];
foreach ($assignments as $lid => $ass) {
    if ($lid === $coastLecturerId) continue;
    if (empty($ass['clusters'])) continue;
    
    $primaryCluster = $ass['clusters'][0];
    
    if (!isset($lecturersByCluster[$primaryCluster])) {
        $lecturersByCluster[$primaryCluster] = [];
    }
    
    $lecturersByCluster[$primaryCluster][] = [
        'id' => $lid,
        'name' => $ass['name'],
        'count' => $ass['count'],
        'student_ids' => $ass['student_ids']
    ];
}

foreach ($lecturersByCluster as $cluster => $lecturers) {
    if (count($lecturers) <= 1) {
        \Log::info("  {$cluster}: only one lecturer, skipping");
        continue;
    }
    
    \Log::info("  Processing {$cluster} with " . count($lecturers) . " lecturers");
    
    
    usort($lecturers, fn($a, $b) => $b['count'] <=> $a['count']);
    
    
    $totalStudents = array_sum(array_column($lecturers, 'count'));
    $numLecturers = count($lecturers);
    
   
    $maxPossible = floor($totalStudents / $MAX_TARGET);
    $lecturersToKeep = min($numLecturers, $maxPossible);
    
    \Log::info("    Total students in cluster: {$totalStudents}");
    \Log::info("    Can fill {$lecturersToKeep} lecturers to MAXIMUM ({$MAX_TARGET})");
    
    if ($lecturersToKeep >= $numLecturers) {
        
        $perLecturer = floor($totalStudents / $numLecturers);
        $remainder = $totalStudents % $numLecturers;
        
        \Log::info("    Giving each lecturer {$perLecturer} students, with {$remainder} extra");
        
       
        $studentIds = [];
        foreach ($lecturers as $l) {
            $studentIds = array_merge($studentIds, $assignments[$l['id']]['student_ids']);
            $assignments[$l['id']]['student_ids'] = [];
            $assignments[$l['id']]['count'] = 0;
        }
        
        $start = 0;
        foreach ($lecturers as $index => $l) {
            $extra = ($index < $remainder) ? 1 : 0;
            $takeCount = $perLecturer + $extra;
            $takeIds = array_slice($studentIds, $start, $takeCount);
            $start += $takeCount;
            
            $assignments[$l['id']]['student_ids'] = $takeIds;
            $assignments[$l['id']]['count'] = count($takeIds);
            
            \Log::info("      → {$l['name']} now has {$assignments[$l['id']]['count']} students");
        }
    } else {
        
        \Log::info("    Filling {$lecturersToKeep} lecturers to MAXIMUM, rest to ONE survivor");
        
       
        $allStudentIds = [];
        foreach ($lecturers as $l) {
            $allStudentIds = array_merge($allStudentIds, $assignments[$l['id']]['student_ids']);
            $assignments[$l['id']]['student_ids'] = [];
            $assignments[$l['id']]['count'] = 0;
        }
        
       
        $start = 0;
        for ($i = 0; $i < $lecturersToKeep; $i++) {
            $lid = $lecturers[$i]['id'];
            $takeCount = $MAX_TARGET;
            $takeIds = array_slice($allStudentIds, $start, $takeCount);
            $start += $takeCount;
            
            $assignments[$lid]['student_ids'] = $takeIds;
            $assignments[$lid]['count'] = count($takeIds);
            
            \Log::info("      → [MAX] {$lecturers[$i]['name']} now has {$assignments[$lid]['count']} students");
        }
        
        
        if ($start < count($allStudentIds)) {
            $survivorIndex = $lecturersToKeep;
            if ($survivorIndex < count($lecturers)) {
                $lid = $lecturers[$survivorIndex]['id'];
                $remainingIds = array_slice($allStudentIds, $start);
                
                $assignments[$lid]['student_ids'] = $remainingIds;
                $assignments[$lid]['count'] = count($remainingIds);
                
                \Log::info("      → [SURVIVOR] {$lecturers[$survivorIndex]['name']} now has {$assignments[$lid]['count']} students");
                
                
                for ($j = $survivorIndex + 1; $j < count($lecturers); $j++) {
                    $assignments[$lecturers[$j]['id']]['student_ids'] = [];
                    $assignments[$lecturers[$j]['id']]['count'] = 0;
                    $assignments[$lecturers[$j]['id']]['clusters'] = [];
                    
                    \Log::info("      → [EMPTY] {$lecturers[$j]['name']} now has 0 students");
                }
            }
        }
    }

$needBalancing = [];
$clustersBalanced = [];

foreach ($assignments as $lid => $ass) {
    if ($lid === $coastLecturerId) continue;
    if (empty($ass['clusters'])) continue;
    if ($ass['count'] == 0) continue;
    
    
    if ($ass['count'] >= $MIN_TARGET) continue;
    
    $primaryCluster = $ass['clusters'][0];
    
    
    if (!in_array($primaryCluster, $clustersBalanced)) {
        $needBalancing[] = [
            'lecturer_id' => $lid,
            'name' => $ass['name'],
            'cluster' => $primaryCluster,
            'needed' => $MIN_TARGET - $ass['count'],
            'current' => $ass['count']
        ];
        $clustersBalanced[] = $primaryCluster;
        
        \Log::info("  → [NEEDS NYERI] {$ass['name']} from {$primaryCluster} needs {$needBalancing[count($needBalancing)-1]['needed']} students");
    }
}
}
    }
if (!empty($nyeriStudents)) {
    $nyeriIds = array_diff($nyeriStudents, $assignedIds);
    $nyeriIds = array_values($nyeriIds);
    
    \Log::info("=== NYERI DISTRIBUTION - " . count($nyeriIds) . " students available ===");
    
    $start = 0;
    $totalNyeri = count($nyeriIds);
    
    
    if (!empty($needBalancing)) {
        \Log::info("  Phase 1: Giving to " . count($needBalancing) . " lecturers who need balancing");
        
        foreach ($needBalancing as $data) {
            if ($start >= $totalNyeri) break;
            
            $takeCount = min($data['needed'], $totalNyeri - $start);
            $takeIds = array_slice($nyeriIds, $start, $takeCount);
            $start += $takeCount;
            
            $assignments[$data['lecturer_id']]['student_ids'] = array_merge($assignments[$data['lecturer_id']]['student_ids'], $takeIds);
            $assignments[$data['lecturer_id']]['count'] += count($takeIds);
            $assignments[$data['lecturer_id']]['clusters'][] = 'nyeri_balancing';
            $assignedIds = array_merge($assignedIds, $takeIds);
            
            \Log::info("    → [BALANCE] {$data['name']} got {$takeCount} Nyeri students");
        }
    }
    
    
    if ($start < $totalNyeri) {
        $remainingNyeri = array_slice($nyeriIds, $start);
        \Log::info("  Phase 2: " . count($remainingNyeri) . " Nyeri left - creating pure clusters");
        
        
        $emptyLecturers = [];
        foreach ($assignments as $lid => $ass) {
            if ($lid === $coastLecturerId) continue;
            if ($ass['count'] == 0) {
                $emptyLecturers[] = $lid;
            }
        }
        
        if (!empty($emptyLecturers)) {
            $perLecturer = $MIN_TARGET;
            $pureStart = 0;
            
            foreach ($emptyLecturers as $lid) {
                if ($pureStart >= count($remainingNyeri)) break;
                
                $takeCount = min($perLecturer, count($remainingNyeri) - $pureStart);
                $takeIds = array_slice($remainingNyeri, $pureStart, $takeCount);
                $pureStart += $takeCount;
                
                $assignments[$lid]['student_ids'] = array_merge($assignments[$lid]['student_ids'], $takeIds);
                $assignments[$lid]['count'] += count($takeIds);
                $assignments[$lid]['clusters'][] = 'nyeri_mt_kenya_cluster';
                $assignedIds = array_merge($assignedIds, $takeIds);
                
                \Log::info("    → [PURE] {$assignments[$lid]['name']} got pure Nyeri cluster ({$takeCount} students)");
            }
        }
    }
}
   
    $allStudentIds = $students->pluck('id')->toArray();
    $finalAssignedIds = [];
    foreach ($assignments as $ass) {
        $finalAssignedIds = array_merge($finalAssignedIds, $ass['student_ids']);
    }
    
    $missingStudents = array_diff($allStudentIds, $finalAssignedIds);
    
    if (!empty($missingStudents)) {
        \Log::warning("⚠️ " . count($missingStudents) . " students still unassigned! Final emergency assignment...");
        
        $allLecturers = array_diff(array_keys($assignments), [$coastLecturerId]);
        
        foreach ($missingStudents as $sid) {
            $lowestLid = null;
            $lowestCount = PHP_INT_MAX;
            
            foreach ($allLecturers as $lid) {
                if ($assignments[$lid]['count'] < $lowestCount) {
                    $lowestCount = $assignments[$lid]['count'];
                    $lowestLid = $lid;
                }
            }
            
            if ($lowestLid) {
                $assignments[$lowestLid]['student_ids'][] = $sid;
                $assignments[$lowestLid]['count']++;
            }
        }
    }

    
    $batch = LecturerAssigment::where([
        'attachment_id' => $request->attachment_id,
        'department_id' => $request->department_id
    ])->max('batch') + 1 ?: 1;

    $inserts = [];
    foreach ($assignments as $lid => $ass) {
        foreach ($ass['student_ids'] as $sid) {
            $inserts[] = [
                'attachment_id' => $request->attachment_id,
                'department_id' => $request->department_id,
                'attachment_student_id' => $sid,
                'attachment_lecturer_id' => $lid,
                
                'company_id' => $studentsById[$sid]->company_id ?? null,
                'batch' => $batch,
                'created_by' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ];
            
            AttachmentStudent::where('id', $sid)->update([
                'attachment_lecturer_id' => $lid
            ]);
        }
    }
    
    LecturerAssigment::insert($inserts);

   
    $totalAssigned = 0;
    $lecturersWithStudents = 0;
    $meetMinimum = 0;

    foreach ($assignments as $ass) {
        $totalAssigned += $ass['count'];
        if ($ass['count'] > 0) $lecturersWithStudents++;
        if ($ass['count'] >= $MIN_TARGET || $ass['id'] === $coastLecturerId) $meetMinimum++;
    }

    \Log::info("=== FINAL STATS ===");
    \Log::info("Total assigned: $totalAssigned/" . count($students));
    \Log::info("Lecturers with students: $lecturersWithStudents/" . count($lecturers));

    return response()->json([
        'status' => 'success',
        'message' => "✅ All $totalAssigned students assigned to $lecturersWithStudents lecturers",
        'summary' => [
            'total_students' => $totalAssigned,
            'total_lecturers' => count($lecturers),
            'lecturers_with_students' => $lecturersWithStudents,
            'min_target' => $MIN_TARGET,
            'max_target' => $MAX_TARGET,
            'lecturers_meeting_minimum' => $meetMinimum,
            'lecturers_below_minimum' => $lecturersWithStudents - $meetMinimum
        ]
    ]);
}public function getStudentCountByLecturer(Request $request)
{
    $request->validate([
        'attachment_id' => 'required|exists:attachments,id',
        'department_id' => 'required|exists:administrative_units,id',
    ]);

    $students = AttachmentStudent::with([
            'attachmentLecturer.lecturer.user',
            'attachment',
            'student.user',
            'student.program.parent',
            'company.town'
        ])
        ->where('attachment_id', $request->attachment_id)
        ->whereNotNull('attachment_lecturer_id')
        ->whereHas('student.program.parent', fn($q) => $q->where('id', $request->department_id))
        ->get();

    // Group by lecturer for summary
    $lecturerCounts = $students->groupBy('attachment_lecturer_id')->map(function($group) {
        $first = $group->first();
        return [
            'lecturer_id' => $first->attachment_lecturer_id,
            'lecturer_name' => $first->attachmentLecturer->lecturer->user->name ?? 'Unknown',
            'student_count' => $group->count()
        ];
    })->values();

    // Format student details for each lecturer
    $lecturerDetails = $students->groupBy('attachment_lecturer_id')->map(function($group) {
        $first = $group->first();
        $lecturerName = $first->attachmentLecturer->lecturer->user->name ?? 'Unknown';
        
        $studentsList = $group->map(function($student) {
            return [
                'id' => $student->id,
                'student_name' => $student->student->user->name ?? 'N/A',
                'reg_no' => $student->student->reg_no ?? 'N/A',
                'company_name' => $student->company->name ?? 'N/A',
                'town' => $student->company->town->name ?? 'N/A',
                'end_date' => $student->end_date ? date('d-m-Y', strtotime($student->end_date)) : 'N/A',
                'phone' => $student->student->user->phone_number ?? 'N/A'
            ];
        })->values();
        
        return [
            'lecturer_id' => $first->attachment_lecturer_id,
            'lecturer_name' => $lecturerName,
            'student_count' => $group->count(),
            'students' => $studentsList
        ];
    })->values();

    return response()->json([
        'status' => 'success',
        'total_students' => $students->count(),
        'total_lecturers' => $lecturerCounts->count(),
        'summary' => $lecturerCounts,
        'detailed' => $lecturerDetails
    ]);
}public function filterByDate(Request $request)
{
    $request->validate([
        'attachment_id' => 'required|exists:attachments,id',
        'department_id' => 'required|exists:administrative_units,id',
        'start_date' => 'nullable|date',
        'end_date' => 'required|date',
    ]);

    // Build the query with date filtering on attachment_students.end_date
    $query = AttachmentStudent::with([
            'attachmentLecturer.lecturer.user',
            'attachment',
            'student.user',
            'student.program.parent',
            'company'
        ])
        ->where('attachment_id', $request->attachment_id)
        ->whereNotNull('attachment_lecturer_id')
        ->whereHas('student.program.parent', fn($q) => $q->where('id', $request->department_id));

    // Filter by the attachment_students.end_date
    if ($request->filled('start_date')) {
        $query->whereDate('end_date', '>=', $request->start_date);
    }
    $query->whereDate('end_date', '<=', $request->end_date);

    $students = $query->get();

    // Get date range of ALL end_dates for this attachment/department
    $allDatesQuery = AttachmentStudent::where('attachment_id', $request->attachment_id)
        ->whereNotNull('attachment_lecturer_id')
        ->whereHas('student.program.parent', fn($q) => $q->where('id', $request->department_id))
        ->selectRaw('MIN(end_date) as min_date, MAX(end_date) as max_date')
        ->first();

    // Group by lecturer for summary
    $lecturerCounts = $students->groupBy('attachment_lecturer_id')->map(function($group) {
        $first = $group->first();
        return [
            'lecturer_id' => $first->attachment_lecturer_id,
            'lecturer_name' => $first->attachmentLecturer->lecturer->user->name ?? 'Unknown',
            'student_count' => $group->count()
        ];
    })->values();

    // Format student details for each lecturer
    $lecturerDetails = $students->groupBy('attachment_lecturer_id')->map(function($group) {
        $first = $group->first();
        $lecturerName = $first->attachmentLecturer->lecturer->user->name ?? 'Unknown';
        
        $studentsList = $group->map(function($student) {
            return [
                'id' => $student->id,
                'student_name' => $student->student->user->name ?? 'N/A',
                'reg_no' => $student->student->reg_no ?? 'N/A',
                'company_name' => $student->company->name ?? 'N/A',
                'town' => $student->company->town->name ?? 'N/A',
                'end_date' => $student->end_date ? date('d-m-Y', strtotime($student->end_date)) : 'N/A',
                'phone' => $student->student->user->phone_number ?? 'N/A'
            ];
        })->values();
        
        return [
            'lecturer_id' => $first->attachment_lecturer_id,
            'lecturer_name' => $lecturerName,
            'student_count' => $group->count(),
            'students' => $studentsList
        ];
    })->values();

    return response()->json([
        'status' => 'success',
        'total_students' => $students->count(),
        'total_lecturers' => $lecturerCounts->count(),
        'summary' => $lecturerCounts,
        'detailed' => $lecturerDetails,
        'filters' => [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ],
        'date_range_info' => [
            'earliest_end_date' => $allDatesQuery->min_date ?? 'N/A',
            'latest_end_date' => $allDatesQuery->max_date ?? 'N/A'
        ]
    ]);
}
    }
