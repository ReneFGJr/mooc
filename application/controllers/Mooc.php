<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mooc extends CI_Controller {

    function __construct() {

        parent::__construct();
        $this -> lang -> load("app", "portuguese");
        $this -> load -> database();
        $this -> load -> helper('url');
        $this -> load -> library('session');

        $this -> load -> helper('form');
        $this -> load -> helper('form_sisdoc');
        $this -> load -> helper('bootstrap');
        $this -> load -> helper('xml');
        #$this -> load -> helper('xml_dom');

        date_default_timezone_set('America/Sao_Paulo');
    }

    private function cab($data = array()) {
        $data['title'] = 'MOOC - Curadoria Digital';
        $this -> load -> view('header/header.php', $data);
        $this -> load -> view('header/menu_top.php', $data);
        $this -> load -> model("socials");
    }

    private function footer($data = array()) {
        $this -> load -> view('header/footer.php');
    }

    public function index() {
        $this -> load -> model('moocs');
        $this -> cab();
        
        $this->load->view('Welcome');
        
        $sx = $this->moocs->courses();
        $data['content'] = $sx;
        $this->load->view("show",$data);

        $this -> footer();
    }
    
    public function course($id='') {
        $this -> load -> model('moocs');
        $this -> cab();
                       
        $sx = $this->moocs->modules($id);
        $data['content'] = $sx;
        $this->load->view("show",$data);

        $this -> footer();
    }    
    
   public function module($id='') {
        $this -> load -> model('moocs');
        $this -> cab();
        $data = $this->moocs->le_module($id);
        $sx = $this->moocs->course($data['id_c']);
        
        $sx .= $this->moocs->module($id);
        $data['content'] = $sx;
        $this->load->view("show",$data);

        $this -> footer();
    }
       
    public function about() {
        $this -> cab();

        $data = array();
        $data['content'] = $this -> load->view('brapci/about',null,true);
        $this -> load -> view('show', $data);
        $this -> footer();
    }    
 

}
