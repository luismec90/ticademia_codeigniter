<?php 
//I assume the first call to updateReadingSpeeds is at minute 0

$data=array();

function updateReadingSpeeds($customerID,$bookID,$pageNumber){
    global $data;
    
    if(!isset($data[$bookID][$customerID])){
        $data[$bookID][$customerID]['customerID']=$customerID;
        $data[$bookID][$customerID]['currentPage']=0;
        $data[$bookID][$customerID]['readingSpeed']=0;
    }else{
        $readingSpeed=$pageNumber-$data[$bookID][$customerID]['currentPage'];
        if($readingSpeed>$data[$bookID][$customerID]['readingSpeed']){
            $data[$bookID][$customerID]['readingSpeed']=$readingSpeed;
        }
        $data[$bookID][$customerID]['currentPage'] = $pageNumber;
    }
}

function printLeaderboard($bookID){
    global $data;
    
    echo "Customer ID,Reading Speed,Rank \n";
    
    usort($data[1],function($a,$b){
        return $b['readingSpeed']-$a['readingSpeed'];
    });
    
    $pos=1;
    foreach($data[$bookID] as $rows){
        echo "Customer {$rows['customerID']},{$rows['readingSpeed']},$pos \n";
        $pos++;
    }
}

updateReadingSpeeds(1,1,0);
updateReadingSpeeds(1, 1, 5);
updateReadingSpeeds(1, 1, 6);
updateReadingSpeeds(1, 1, 8);
updateReadingSpeeds(1, 1, 12);
updateReadingSpeeds(1, 1, 15);
updateReadingSpeeds(1, 1, 17);
updateReadingSpeeds(1, 1, 21);
updateReadingSpeeds(1, 1, 24);
updateReadingSpeeds(1, 1, 27);
updateReadingSpeeds(1, 1, 29);
updateReadingSpeeds(1, 1, 31);
updateReadingSpeeds(1, 1, 37);
updateReadingSpeeds(1, 1, 42);
updateReadingSpeeds(1, 1, 49);
updateReadingSpeeds(1, 1, 52);



printLeaderboard(1);
