<?php

namespace App\Http\Controllers;
use App\Models\AttachmentLecturer;
use App\Models\student;
use App\Models\Lecturer;
use App\Models\AttachmentStudent;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    
    public function budgets()
{
    $attachment_lecturers = DB::table('attachment_lecturers')
        ->join('lecturers', 'lecturers.id', '=', 'attachment_lecturers.lecturer_id')
        ->join('users', 'users.id', '=', 'lecturers.user_id')
        ->select('attachment_lecturers.*', 'users.name as real_name')
        ->get();

    foreach ($attachment_lecturers as $al) {
       
        $gradeData = DB::table('job_grades')
            ->where('dekut_grade', $al->job_grade)
            ->first();

        $rate = $gradeData->daily_allowance ?? 0;

        
        $visits = DB::table('lecturer_assignments')
            ->join('companies', 'companies.id', '=', 'lecturer_assignments.company_id')
            ->where('lecturer_assignments.attachment_lecturer_id', $al->id)
            ->select(
                'companies.address as town', 
                DB::raw('COUNT(*) as students_count')
            )
            ->groupBy('companies.address')
            ->get();

        
        foreach ($visits as $visit) {
            $visit->cluster = $this->getClusterName($visit->town);
            $visit->transport_cost = $this->calculateTransport($visit->town);
        }

        
        $clusteredVisits = collect($visits)->groupBy('cluster')->map(function($visits, $cluster) {
            return [
                'cluster' => $cluster,
                'total_students' => $visits->sum('students_count'),
                'towns' => $visits->pluck('town')->map(function($town) {
                    return str_replace([' Road', ' Rd', ' Street', ' St'], '', $town);
                })->unique()->values()->toArray(),
                'transport_cost' => $visits->first()->transport_cost ?? 0
            ];
        })->values()->toArray();

        
        $uniqueClusters = collect($visits)->pluck('cluster')->unique()->values()->toArray();
        
        
        $clusterCounts = [];
        foreach ($visits as $visit) {
            if (!isset($clusterCounts[$visit->cluster])) {
                $clusterCounts[$visit->cluster] = 0;
            }
            $clusterCounts[$visit->cluster] += $visit->students_count;
        }
        
        $primaryCluster = null;
        $maxCount = 0;
        foreach ($clusterCounts as $cluster => $count) {
            if ($count > $maxCount) {
                $maxCount = $count;
                $primaryCluster = $cluster;
            }
        }
        
        
        $totalTransport = 0;
        if ($primaryCluster) {
            
            $visitInPrimary = collect($visits)->firstWhere('cluster', $primaryCluster);
            if ($visitInPrimary) {
                $totalTransport = $visitInPrimary->transport_cost;
                
                
                if ($primaryCluster === 'mombasa_road_cluster') {
                    
                    $hasFrontier = in_array('frontier_cluster', $uniqueClusters);
                    if ($hasFrontier) {
                        $totalTransport = 14000; 
                    }
                }
            }
        }

        $al->lecturer_name = $al->real_name; 
        $al->dekut_grade = $al->job_grade ?? 'N/A';
        $al->assessmentVisits = $visits;
        $al->clusteredVisits = $clusteredVisits;
        $al->unique_cluster_count = count($uniqueClusters);
        $al->primary_cluster = $primaryCluster;
        $al->town_count = $visits->count(); 
        $al->daily_rate_used = $rate;
        $al->total_subsistence = $al->town_count * $rate; 
        $al->total_transport = $totalTransport; 
    }

    return view('admin.budgets', compact('attachment_lecturers'));
}
   private function calculateTransport($address)
{
    $location = strtolower($address);
    
    
    $clusters = [
        'nairobi_metro' => [
            'towns' => ['cbd', 'upperhill','nairobi '],
            'cost' => 9000
        ],
        'nairobi_westlands' => [
            'towns' => ['westlands', 'parklands', 'kilimani', 'kileleshwa', 'kangemi', 'loresho'],
            'cost' => 9000
        ],
        'thika_road' => [
            'towns' => ['thika', 'makuyu', 'ruiru', 'juja', 'limuru', 'kiambu', 'gikuyu'],
            'cost' => 9000
        ],
        'kasarani_cluster' => [
            'towns' => ['kasarani', 'roysambu', 'githurai', 'kahawa', 'zimmerman', 'muthaiga'],
            'cost' => 9000
        ],
        'nakuru_cluster' => [
            'towns' => ['nakuru', 'naivasha', 'nyahururu', 'gilgil', 'molo', 'eldama ravine', 'ol kalou', 'rumuruti','nanyuki'],
            'cost' => 13000
        ],
        
        'western_cluster' => [
            'towns' => ['kakamega', 'mumias', 'kisumu', 'homa bay', 'muhoroni', 'vihiga', 'bungoma', 'webuye', 
                       'kimilili', 'malakisi', 'busia', 'malaba', 'mbale', 'eldoret', 'siaya', 'bondo', 
                       'ugunja', 'ukwala', 'yala', 'nyamira', 'nyansiongo', 'migori', 'rongo'],
            'cost' => 17000
        ],
        'nyeri_mt_kenya_cluster' => [
            'towns' => ['nyeri', 'othaya', 'mweiga'],
            'cost' => 9000
        ],
        'meru_embu_cluster' => [
            'towns' => ['meru', 'maua', 'karatina', 'chuka', 'embu', 'ol kalou', 'kenol', 'mwea', 
                       'sagana', 'muranga', 'maragua', 'kangema', 'runyenjes', 'kerugoya', 'kutus', 'kirinyaga'],
            'cost' => 9000
        ],
        'coast_cluster' => [
            'towns' => ['mombasa', 'mtwapa', 'kilifi', 'malindi', 'voi', 'mariakani', 'ukunda', 'likoni', 'nyali', 'changamwe'],
            'cost' => 17000
        ],
        'mombasa_road_cluster' => [
            'towns' => ['machakos', 'kangundo-tala', 'matuu', 'kitui', 'mwingi', 'makueni', 'mombasa road', 
                       'donholm', 'eastleigh', 'embakasi', 'umoja', 'athi river', 'kitengela', 'pipeline', 
                       'south b', 'south c', 'buruburu'],
            'cost' => 9000
        ],
        'frontier_mombasa_road_cluster' => [
            'towns' => [
                
                'machakos', 'kangundo-tala', 'matuu', 'kitui', 'mwingi', 'makueni', 'mombasa road', 
                'donholm', 'eastleigh', 'embakasi', 'umoja', 'athi river', 'kitengela', 'pipeline', 
                'south b', 'south c', 'buruburu',
                
                'garissa', 'wajir', 'mandera', 'isiolo', 'moyale', 'lodwar', 'kakuma', 'maralal', 'samburu'
            ],
            'cost' => 14000  
        ],
        'kericho_south_rift_cluster' => [
            'towns' => ['kericho', 'litein', 'kipkelion', 'londiani', 'bomet', 'narok', 'iten', 'tambach', 
                       'nandi hills', 'kapsabet', 'kitale', 'kabarnet'],
            'cost' => 15000
        ],
        
    ];
    
    
    foreach ($clusters as $cluster) {
        foreach ($cluster['towns'] as $town) {
            if (str_contains($location, $town)) {
                return $cluster['cost'];
            }
        }
    }
    
    
    return 800;
}
private function getClusterName($address)
{
    $location = strtolower($address);
    
    
    $location = str_replace([' road', ' rd', 'street', ' st', 'avenue', ' ave', 'lane', ' ln'], '', $location);
    $location = trim($location);
    
    $clusters = [
        'nairobi_metro' => ['cbd', 'upperhill', 'nairobi'],
        'nairobi_westlands' => ['westlands', 'parklands', 'kilimani', 'kileleshwa', 'kangemi', 'loresho'],
        'thika_road' => ['thika', 'makuyu', 'ruiru', 'juja', 'limuru', 'kiambu', 'gikuyu'],
        'kasarani_cluster' => ['kasarani', 'roysambu', 'githurai', 'kahawa', 'zimmerman', 'muthaiga'],
        'mombasa_road_cluster' => ['machakos', 'kangundo-tala', 'matuu', 'kitui', 'mwingi', 'makueni', 'mombasa road', 'donholm', 'eastleigh', 'embakasi', 'umoja', 'athi river', 'kitengela', 'pipeline', 'south b', 'south c', 'buruburu'],
        'nakuru_cluster' => ['nakuru', 'naivasha', 'nyahururu', 'gilgil', 'molo', 'eldama ravine', 'ol kalou', 'rumuruti', 'nanyuki'],
        'western_cluster' => ['kakamega', 'mumias', 'kisumu', 'homa bay', 'muhoroni', 'vihiga', 'bungoma', 'webuye', 'kimilili', 'malakisi', 'busia', 'malaba', 'mbale', 'eldoret', 'siaya', 'bondo', 'ugunja', 'ukwala', 'yala', 'nyamira', 'nyansiongo', 'migori', 'rongo', 'kisii'],
        'nyeri_mt_kenya_cluster' => ['nyeri', 'othaya', 'mweiga', 'maralal'],
        'meru_embu_cluster' => ['meru', 'maua', 'karatina', 'chuka', 'embu', 'ol kalou', 'kenol', 'mwea', 'sagana', 'muranga', 'maragua', 'kangema', 'runyenjes', 'kerugoya', 'kutus', 'kirinyaga'],
        'coast_cluster' => ['mombasa', 'mtwapa', 'kilifi', 'malindi', 'voi', 'mariakani', 'ukunda', 'likoni', 'nyali', 'changamwe'],
        'frontier_cluster' => ['garissa', 'wajir', 'mandera', 'isiolo', 'moyale', 'lodwar', 'kakuma', 'samburu'],
        'kericho_south_rift_cluster' => ['kericho', 'litein', 'kipkelion', 'londiani', 'bomet', 'narok', 'iten', 'tambach', 'nandi hills', 'kapsabet', 'kitale', 'kabarnet'],
    ];
    
    foreach ($clusters as $clusterName => $towns) {
        foreach ($towns as $town) {
            if (str_contains($location, $town)) {
                return $clusterName;
            }
        }
    }
    
   
    $firstWord = explode(' ', $location)[0];
    foreach ($clusters as $clusterName => $towns) {
        foreach ($towns as $town) {
            if ($firstWord === $town || str_contains($town, $firstWord)) {
                return $clusterName;
            }
        }
    }
    
    return 'uncategorized';
}
}