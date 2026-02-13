<?php

namespace App\Controllers;

use App\Models\WordsModel;

class FiveForks extends BaseController
{
    public function getIndex() {
        $words_model = model('WordsModel');
        $max = $words_model->selectMax('day')->first();
        return view('ff',$max);


/*
//DEBUG: con file_get_contents non funziona, quidi devo usare la libreria CURL e passare alla libreria di parsing HTML direttamente il contenuto

                        $options = array(
                                'http'=>array(
//                                      'header'=>"User-Agent Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:140.0) Gecko/20100101 Firefox/140.0\r\n"
                                        'header'=>"gcangini\r\n"
                                ),
                                'ssl' => array(
                                    'verify_peer' => false,
                                    'verify_peer_name' => false,
                                ),
                        );
                        $context = stream_context_create($options);
 */
/*
                        try {
                                $ch = curl_init($url);
//                              curl_setopt($ch, CURLOPT_HEADER, 0);
                                curl_setopt($ch, CURLOPT_USERAGENT, "gcangini");
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                                $html_str = curl_exec($ch);
                                curl_close($ch);


                                $html = str_get_html($html_str);
//                              $html = file_get_html($url,false,$context);
                                $res = $html->find('div#chronlist',0)->innertext;
                                $matches = array();
                                if (is_string($res)) {
                                        while (preg_match("/(.{5})\s".++$max."\s(\d\d)\/(\d\d)\/(\d\d)/",$res,$matches)) {
                                                $new = array("word" => $matches[1], "id" => $max, "day" => "20".$matches[4]."/".$matches[2]."/".$matches[3]);
                                                $wordle_model->insert($new);
                                                // DEBUG
                                                //$data['res'] = "Found new word ".$new["word"]." #".$new["id"]."(".$new["day"].")";
                                        }
                                }
                        } catch (\Exception $e) {
                                $this->data['error'] = $e->getMessage();
                        }
                                */
    }
}