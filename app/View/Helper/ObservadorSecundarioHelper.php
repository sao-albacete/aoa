<?php
/* /app/View/Helper/ObservadorSecundarioHelper.php */

App::uses('AppHelper', 'View/Helper');

class ObservadorSecundarioHelper extends AppHelper {
    
    public function mostrar_codigos_observadores($observadores) {
        
        $out = "";
        
        if(!empty($observadores)) {
            
            foreach($observadores as $observador) {
                
                $out .= "<a href='/cita/index?colaboradorId=".$observador['ObservadorSecundario']['id']."' title='".$observador['ObservadorSecundario']['nombre']."'>".$observador['ObservadorSecundario']['codigo']."</a> "; 
            }
        }
        
        return $out;
    }
    
    public function mostrar_ids_observadores($observadores) {
         
        $out = "";
         
        if(!empty($observadores)) {
    
            foreach($observadores as $observador) {
                 
                $out .= $observador['ObservadorSecundario']['id'].",";
            }
        }
         
        return substr($out, 0, -1);
    }
    
    public function mostrar_nombres_observadores($observadores) {
        
        $out = "";
        
        if(!empty($observadores)) {
            
            foreach($observadores as $observador) {
                
                $out .= "<span>".$observador['ObservadorSecundario']['codigo']." - ".$observador['ObservadorSecundario']['nombre']."</span>, "; 
            }
            $out = rtrim($out, ", ");
        } else {
            $out = "-";
        }
        
        return $out;
    }
}