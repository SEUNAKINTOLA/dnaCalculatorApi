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
        $retlst = array();
        $currentGene = "";
        $currentGsAndCs = 0;


        for($i=0; $i< strlen($dna); $i++){
            $currentCodon = substr($dna,$i, 3);
            if($startGeneDetected){
                
                if("C" == substr($dna,$i, 1)) $currentGsAndCs++;
                if("G" == substr($dna,$i, 1)) $currentGsAndCs++;
                $sequenceLength++;
                $currentGene .= substr($dna,$i, 1);
                if(in_array($currentCodon, $endGeneStructure)){
                    if($sequenceLength > 0 && $sequenceLength%3 == 0) {
                        $startGeneDetected = false;
                        $count++;
                        
                        $currentGene .= substr($dna,$i+1, 2);
                        $currentGsAndCs += substr_count(substr($dna,$i, 2),"C");
                        $currentGsAndCs += substr_count(substr($dna,$i, 2),"G");
                        $retlst['validgenes'][$count] ['gene']=  $currentGene;
                        $retlst['validgenes'][$count]['cgratio']  =  "$currentGsAndCs/".strlen($currentGene);
                        $i +=2;
                    }
                }   
            }
            
            if(in_array($currentCodon, $startGeneStructure)){
                $currentGsAndCs = 0;
                $startGeneDetected = true;
                $sequenceLength  = -3;
                $currentGene = substr($dna,$i, 1);
                if("C" == substr($dna,$i, 1)) $currentGsAndCs++;
                if("G" == substr($dna,$i, 1)) $currentGsAndCs++;
            }
        }
        
        $retlst['genecount']   =  $count;
        return $retlst;
    }
        
}

?>