<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Telegram extends CI_Controller {
    
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('telegram_model','tel_mod');
        $this->load->model("mikrotik/Mikrotik_model","mikrotik");
        
    }
    

    public function index()
    {

        // echo json_encode($this->tel_mod->check_user(338987820));
        // exit;

        $keyboard = array(
            'keyboard' => array(
                array("/start","/daftar","/voucher"),
                array("/update","/pin","/user"),
            
        ));
        $encodedKeyboard = json_encode($keyboard);
        $content = array('chat_id' => 338987820, 'text' => "button",'reply_markup' =>$encodedKeyboard);
        $this->tel_bot->sendMessage($content);

    }

    function service()
    {
        $update_id = 339621000;
        while(true)
        {
            $result = $this->tel_bot->getUpdates($update_id+1, 1);
            
            foreach($result['result'] as $row)
            {
    
                switch (array_keys($row)[1]) {
                    case 'message':
                        $update_id = $row['update_id'];
                        $message = $row['message'];
                        $this->tel_mod->chat($update_id,$message);
                        $this->message($message);
                        break;
                    case 'callback_query':
                        $this->callback_query($row['callback_query']);
                        break;
                    
                    default:
                        $update_id = $row['update_id'];
                        $message = $row['message'];
                        $this->tel_mod->chat($update_id,$message);
                        $this->reg_user($message);
                        break;
                }
            }
            sleep(1);
          
        }
        
    }

    private function callback_query($data)
    {
        $sess = array('id'          => NULL,
                      'id_counter'  => $data['from']['id'],
                      'callback'    => $data['data'],
                      'next_step'   => true);
        $this->tel_mod->saveSession($sess);

        $content = array('chat_id' => $data['from']['id'], 'text' => "Silahkan masukan No Telp.");
        $this->tel_bot->sendMessage($content);
    }

    private function message($message)
    {

        if(isset($message['entities'])){
            $entities = $message['entities'];
            foreach($entities as $key)
            {
                switch (strtoupper(substr($message['text'], $key['offset'], $key['length']))) {
                    case '/DAFTAR':
                        $this->register($message);
                        break;
                    case '/UPDATE':
                        $this->update($message);
                        break;
                    case '/VOUCHER':
                        $this->voucher($message);
                        break;
                    case '/START':
                        $this->start($message);
                        break;
                    default:
                        $this->reg_user($message);
                        break;
                }
            }
            
        }
        else
        {
            
            $this->reg_user($message);

        }
    }

    private function start($data)
    {
        $keyboard = array(
            'keyboard' => array(
                array("/start","/daftar","/voucher"),
                array("/update","/pin","/user")
            ),
            "resize_keyboard" => true,
            "one_time_keyboard" => true
        );

        $encodedKeyboard = json_encode($keyboard);

        $content = array('chat_id' => $data['chat']['id'],"text"=>"Selamat datang di situ.net",'reply_markup' =>$encodedKeyboard);
        echo "+";
        return $this->tel_bot->sendMessage($content);
    }

    function voucher($message)
    {
        $user = $this->tel_mod->check_user($message['chat']['id']);
        if($user->num_rows() == 1)
        {
            $user = $user->row();
            $profile = $this->tel_mod->getProfile($user->id_router);
            $content = $this->sendVoucher($user->id_router,$message['chat']['id']);
            
            $this->tel_bot->sendMessage($content);

        }
        else
        {
            $content = array('chat_id' => $message['chat']['id'], 'text' => "Maaf anda belum terdaftar menjadi agen kami \n untuk daftar menjadi agen silahkan ketik \n /DAFTAR");
            $this->tel_bot->sendMessage($content);
        }
    }

    function reg_user($data)
    {
        $user = $this->tel_mod->check_user($data['chat']['id']);

        if($user->num_rows() != 0)
        {
            $user = $user->row();
            $session = $this->tel_mod->checkSession($user->id_telegram);
            if($session->num_rows() == 1)
            {
                $session = $session->row();
                if($session->next_step)
                {
                    $length = rand(5,8);
                    $profile = $this->tel_mod->getProfile($user->id_router,$session->callback);
                    if($profile->num_rows() == 1)
                    {
                        $profile = $profile->row();
                        $pass = strtoupper(random_string('alnum',$length));
                        $user = array('id_router' => $user->id_router,
                                      'username'=> $data['text'],
                                      'password'=> $pass,
                                      'profile' => $profile->name,
                                      'price'   => $profile->price,
                                      'op_id'   => $data['chat']['id'] );
                        
                        $reg = $this->tel_mod->regUser($user);
                        if($reg['ok'])
                        {
                            $this->tel_mod->sessionStop($session->id);
                        }

                        $content = array('chat_id' => $data['chat']['id'], 'text' => $reg['result']);
                        
                    }
                }
                else
                {
                    $content = $this->sendVoucher($user->id_router,$data['chat']['id']);
                }
            }
            else
            {
                $content = $this->sendVoucher($user->id_router,$data['chat']['id']);
            }

            $this->tel_bot->sendMessage($content);        
        }
        else
        {
            $content = array('chat_id' => $data['chat']['id'], 'text' => "Maaf anda belum terdaftar menjadi agen kami \n untuk daftar menjadi agen silahkan ketik \n /DAFTAR");
            $this->tel_bot->sendMessage($content);
            echo "+";
        }
    }

    function get()
    {
        $result = $this->tel_bot->getUpdates();
        echo json_encode($result);
    }

    private function register($data = NULL)
    {
        $options = ['cost' => 5,
                    'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
                    ];
        $pass    = random_string('alnum',5);
        $data['chat']['pass'] = password($pass,$options);        
        if($this->tel_mod->register($data))
        {
            
                
            
            $content = array('chat_id' => $data['chat']['id'],
                             'text' =>  "Registrasi Berhasil. \n".
                                        "informasi akun website \n".
                                        "Username : ".$data['chat']['id']." \n".
                                        "Pasword  : $pass \n".
                                        "website http://situnet/admin");
            $this->tel_bot->sendMessage($content);
            echo "+";
            sleep(1);
        }
        else
        {
            $content = array('chat_id' => $data['chat']['id'], 'text' => "HAI. \n".$data['chat']['last_name']." " .$data['chat']['first_name']." \n ANDA SUDAH TERDAFTAR");
            $this->tel_bot->sendMessage($content);
            echo "-";
            sleep(1);
        }
        
        // echo json_encode($data);
        
    }

    private function update($data)
    {
        if($this->tel_mod->register($data,true))
        {
            $content = array('chat_id' => $data['chat']['id'], 'text' => "HAI. \n".$data['chat']['last_name']." " .$data['chat']['first_name']." \n DATA BERHASIL DIPERBAHARUI");
            $this->tel_bot->sendMessage($content);
            echo "+";
            sleep(1);
        }
        
    }

    function photo()
    {
        //$data = $this->telegram->sendPhoto(338987820,"assets/images/mega-menu/06.jpg","test upload");
        $img = curl_file_create(realpath("assets/Jaran Goyang ~ Nella Kharisma [Official Video HD].mp3")); 
        $content = array('chat_id' => 338987820, 'audio' => $img);
        // echo json_encode($content);
        echo json_encode($this->telegram->sendAudio($content));

       
       // echo json_encode($data);
    }

    private function sendVoucher($id,$id_chat)
    {
        $profile = $this->tel_mod->getProfile($id);
        $keyboard = array('inline_keyboard' => array(array()));
        $x = 0;
        $y = 0;
        foreach ($profile->result_array() as $row)
        {
            $y += (($x % 1) == 0 )? 1:0;
            $key = array('text' => $row['name']." ".number_format($row['price'],0,',','.')."\n ".$row['validity'],'callback_data' => $row['kode']);
            $keyboard['inline_keyboard'][$y][] = $key;
            $x++;
        }

        $encodedKeyboard = json_encode($keyboard);

        $content = array('chat_id' => $id_chat, 'text' => "Silahkan pilih voucher!",'reply_markup' =>$encodedKeyboard);

        return $content;
    }

}

/* End of file Telegram.php */
?>
