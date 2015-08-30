<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Index extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->view('listaEmails');
    }

    /**
     * Função de retorno dos emails (ajax)
     */
    public function consultaEmails() {
        $this->load->model('emailModel', 'email');
        $result = $this->email->getLastEmails();
        $tot = $this->email->countEmails();


        $div = "<div class='row'>
                    <div class='col-md-8 bgTopo'>
                        <h3> Lista de Email</h3><p class='right'>Total de registros: {$tot['total']}</p>
                    </div>
                    ";

        foreach ($result as $row) {
            $div .= "<div class='col-md-8 line'>
                        <p>{$row['email']} </p>
                    </div>";
        }
        
        $div .= '</div>';
        
        echo $div;
    }

}
