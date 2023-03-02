<?php

class Utils
{
    public function returnMessage($code, $status, $returnedData)
    {
        http_response_code($code);
        if ($code == 200) {
            echo json_encode($returnedData, JSON_PRETTY_PRINT);
        } else {
            echo json_encode(array("status" => $status, "returnedData" => $returnedData), JSON_PRETTY_PRINT);
        }
    }

    private function ConcatPaths($p_imagen_paths, $ruta_imagenes, $ruta_web_imagenes)
    {
        $p_imagen_paths_concat = '';
        foreach ($p_imagen_paths as $path) {

            $path = str_replace($ruta_imagenes, $ruta_web_imagenes, $path);
            $path = str_replace("\\", '/', $path);
            $p_imagen_paths_concat = $p_imagen_paths_concat . $path . ';';
        }
        return $p_imagen_paths_concat;
    }

    private function getGUID()
    {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((double) microtime() * 10000); //optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45); // "-"
            $uuid = "" //chr(123) // ""
                . substr($charid, 0, 8) . $hyphen
                . substr($charid, 8, 4) . $hyphen
                . substr($charid, 12, 4) . $hyphen
                . substr($charid, 16, 4) . $hyphen
                . substr($charid, 20, 12)
                . ""; //chr(125); // ""
            return $uuid;
        }
    }

    public function grabarImagenesEnServer($p_imagesArray, $imageName, $ruta_imagenes, $ruta_web_imagenes)
    {
        $imageGUID = $this->getGUID();
        $rutas = array();
        $intentos = 0;
        while (true || $intentos <= 3) {
            try {
                $intentos++;
                if (!file_exists($ruta_imagenes)) {
                    mkdir($ruta_imagenes, true);
                }

                $i = 1;
                foreach ($p_imagesArray as $blob) {

                    $filename = $this->buildPath($ruta_imagenes, "$imageName - $imageGUID - $i.png");
                    // echo $filename;
                    file_put_contents($filename, base64_decode($blob));
                    array_push($rutas, $filename);
                    $i++;
                }
                break;
            } catch (Exception $e) {
                if (!file_exists($ruta_imagenes)) {
                    mkdir($ruta_imagenes, true);
                }

            }
        }

        $concatPaths = $this->ConcatPaths($rutas, $ruta_imagenes, $ruta_web_imagenes);
        return substr($concatPaths, 0, -1);
    }

    public function filterEntries($jsonBody)
    {
        $filters = [FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW];
        $dbParams = [];
        foreach ($jsonBody as $key => $value) {
            if (strpos(strtolower($key), 'imagen') === false) {
                $dbParams[$key] = filter_var($value, ...$filters);
            } else {
                $dbParams[$key] = $value;
            }
        }
        return $dbParams;
    }

    public function exportImagesFromParams($dbParams, $imageName, $proceso, $subFolder)
    {
        $subFolder = trim($subFolder);
        $ruta_imagenes = $this->buildPath(getenv('RUTA_IMAGENES'), $proceso, $subFolder);
        $ruta_web_imagenes = implode('/', [getenv('RUTA_WEB_IMAGENES'), $proceso, $subFolder]);

        foreach ($dbParams as $key => $value) {
            if (strpos(strtolower($key), 'imagen') !== false) {

                $dbParams[$key] = $this->grabarImagenesEnServer($dbParams[$key], $imageName . ' - ' . $key, $ruta_imagenes, $ruta_web_imagenes);
            }
        }
        return $dbParams;
    }


    public function buildPath(...$parts)
    {
        return implode(DIRECTORY_SEPARATOR, $parts);
    }

    public function randomSmsCode()
    {
        $code = chr(rand(65, 90));
        $code .= rand(10000, 99999);
        return $code;
    }
}

?>