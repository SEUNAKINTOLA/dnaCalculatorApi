<?php 
class ExtractValidGenes {

    private $dna = null;
    public function __construct($request){
        if (isset($request['dna'])) {
            $this->dna = $request['dna'];
         }
    }
    
    public function get(){
        if($this->dna == null)  return 'dna must be provided';
        $dna = $this->dna;
        
        $startGeneStructure = ["ATG"];
        $endGeneStructure = ["TAA","TAG","TGA"];
        $startGeneDetected = false;
        $sequenceLength  = -2;
        $count   = 0;
        $ratio = "";
        $Cs = 0;


        for($i=0; $i< strlen($dna); $i++){
            $currentCodon = substr($dna,$i, 3);
           // echo "<br> $i. $currentCodon $sequenceLength";
            if($startGeneDetected){
                $sequenceLength++;
                if(in_array($currentCodon, $endGeneStructure)){
                    if($sequenceLength > 0 && $sequenceLength%3 == 0) {
                        $Cs+=2;
                    //    echo "<br> found end $sequenceLength  $currentCodon";
                        $startGeneDetected = false;
                        $count++;
                    }
                }   
            }
            
            if(in_array($currentCodon, $startGeneStructure)){
                $startGeneDetected = true;
                $sequenceLength  = -3;
            }
        }
        
        $ratio = "$Cs".'/'.strlen($dna);
        $retlst['genecount']   =  $count;
        $retlst['cgratio']       =  $ratio;
        return $retlst;
    }
        
}

?>