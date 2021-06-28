<?php 
class CalculateCGR {

    private $gene = null;
    public function __construct($request){
        if (isset($request['gene'])) {
            $this->gene = $request['gene'];
         }
    }
    
    public function get(){
        if($this->gene == null)  return 'gene must be present';
        if(strlen($this->gene)%3 != 0)  return 'please provide a valid gene';

        $currentGsAndCs = 0;
        $currentGsAndCs += substr_count($this->gene ,"C");
        $currentGsAndCs += substr_count($this->gene ,"G");
        $retlst['gene']=  $this->gene;
        $retlst['cgratio']  =  "$currentGsAndCs/".strlen($this->gene);
        return $retlst;
    }
        
}

?>