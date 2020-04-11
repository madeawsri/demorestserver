<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class SysController 
{

    /**
     * @noAuth
     */
    private function info($info = null)
    {
        echo "<br/><center><b>API Server JWT v1.".((isset($info) && $info=='tlen') ? $info : null)." is <a href='/routes'>WORK!</a></b></center>";
    }

    /**
     * @noAuth
     * @url GET /
     * @url GET /index
     */
    public function index()
    {
        if(file_exists(SRVPATH.'/views/index.php')){
            include(SRVPATH.'/views/index.php');
        } else  {

            try {
                Capsule::connection('default')->table(Capsule::raw('DUAL'))->first([Capsule::raw(1)]);
            } catch(\Exception $e) {
               echo '<center>การเชื่อมต่อ DB ผิดพลาด กรุณาตั้งค่าใน .env ใหม่ </center>';
            }
            $this->getrouteinfo();
            exit(0);
        }
    }

    
    /**
    *@noAuth
    * @url GET /routes
    * @ url GET /routes/$info
    * @ url GET /routes/$info/$controller
    *----------------------------------------------
    *FILE NAME:  SysController.php gen for Servit Framework Controller
    *Created by: Tlen<limweb@hotmail.com>
    *DATE:  2020-03-16(Mon)  13:41:47 
    
    *----------------------------------------------
    */
    public function getRoutes($info = null, $controller = null) {
            $this->getrouteinfo($info, $controller);
    }
    
    

    private function getrouteinfo($info=null,$controller=null){
        $info = 'tlen';
        $this->info($info);
        if ($this->server->mode == 'debug' ) {
            echo '<style> .divline { width:100%; text-align:center; border-bottom: 1px dashed #000; line-height:0.1em; margin:10px 0 20px; } 
            </style>
            <center><table><thead><tr><td><b>Route</b></td><td><b>Controller</b></td><td><b>Method</b></td><td><b>$args</b></td><td>null</td><td><b>@noAuth</b></td></tr></thead><tbody>';
            foreach ($this->server->map as $routekey => $routes) {
                echo '<tr><td colspan="6"><div style="display:flex;padding-right:10px;height:15px;">
                <div class="divline" style="width:200px;">&nbsp;</div>
                <span style="white-space: pre;">&nbsp;>&nbsp;@url '.$routekey.'&nbsp;</span>
                <div class="divline">&nbsp;</div>
                </div>
                </td></tr>';
                switch ($routekey) {
                    case 'GET':
                        foreach ($routes as $key => $value) {
                            if (!in_array($key,['get_header','get_footer','gettheme'])){
                                if ($controller) {
                                    if (strtolower($value[0])==strtolower($controller)) {
                                        echo "<tr><td>".($routekey =='GET' ? '<a href="http://'.$_SERVER['HTTP_HOST'].'/'.$key.'">'.( empty($key) ? '/' : $key ).'</a>'    : $key)."</td><td>$value[0]</td><td>$value[1]</td><td><pre>".json_encode($value[2])."</pre></td><td>".json_encode($value[3])."</td><td>".json_encode($value[4])."</td></tr>";
                                    }
                                } else {
                                    echo "<tr><td>".($routekey =='GET' ? '<a href="http://'.$_SERVER['HTTP_HOST'].$this->server->root.$key.'">'.( empty($key) ? '/' : $key ).'</a>'    : $key)."</td><td>$value[0]</td><td>$value[1]</td><td><pre>".json_encode($value[2])."</pre></td><td>".json_encode($value[3])."</td><td>".json_encode($value[4])."</td></tr>";
                                }
                            }
                        }
                        break;
                    case 'POST':
                    case 'OPTIONS':
                    default:
                        foreach ($routes as $key => $value) {
                            if ($controller) {
                                if (strtolower($value[0])==strtolower($controller)) {
                                    echo "<tr><td style='cursor:pointer;' onclick='alert(\"".$key."\")'>$key</td><td>$value[0]</td><td>$value[1]</td><td><pre>".json_encode($value[2])."</pre></td><td>".json_encode($value[3])."</td><td>".json_encode($value[4])."</td></tr>";
                                }
                            } else {
                                echo "<tr><td style='cursor:pointer;' onclick='alert(\"".$key."\")'>$key</td><td>$value[0]</td><td>$value[1]</td><td><pre>".json_encode($value[2])."</pre></td><td>".json_encode($value[3])."</td><td>".json_encode($value[4])."</td></tr>";
                            }
                        }
                        break;
                }
            }
            echo '<tr><td colspan="6"><div style="display:flex;padding-right:10px;height:15px;">
            <div class="divline">&nbsp;</div>
            <span style="white-space: pre;">&nbsp;>&nbsp;END.&nbsp;</span>
            </div></td></tr>';
            echo '</tbody></table></center>';
        }
        exit(0);
    }

}