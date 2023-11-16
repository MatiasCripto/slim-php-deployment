<?php

class CSV
{
    public static function ExportarCSV($path)
    {
        $listaProductos = Producto::GetProductos();
        $file = fopen($path, "w");
        foreach($listaProductos as $producto)
        {
            $separado= implode(",", (array)$producto);  
            if($file)
            {
                fwrite($file, $separado.",\r\n"); 
            }                           
        }
        fclose($file);  
        return $path;     
    }

    public static function ImportarCSV($path)
    {
        $aux = fopen($path, "r");
        $array = [];
        if(isset($aux))
        {
            try
            {
                while(!feof($aux))
                {
                    $datos = fgets($aux);                        
                    if(!empty($datos))
                    {          
                        array_push($array, $datos);                                                
                    }
                }
            }
            catch(Exception $e)
            {
                echo "Error:";
                echo $e;
            }
            finally
            {
                fclose($aux);
                return $array;
            }
        }
    }
}
?>