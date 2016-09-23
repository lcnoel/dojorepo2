<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property Grocery_crud_model $Grocery_crud_model Optional description            // ===== AGREGADO ===== //
 * @property Dojo_model $Dojo_model Optional description            // ===== AGREGADO ===== //
 * @property stdClass db
 *
 *
 */

class Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		//$this->load->helper('url');

		$this->load->library('grocery_CRUD');

        $this->load->helper(array('form','url','security','file','html','date'));   // ===== AGREGADO ===== //
        $this->load->library(array('session','form_validation','email','upload'));  // ===== AGREGADO ===== //

        $this->load->model('Grocery_crud_model');                                   // ===== AGREGADO ===== //
        $this->load->model('Dojo_model');                                           // ===== AGREGADO ===== //
        $this->load->helper('selectdojo');                                          // ===== AGREGADO ===== //
	}

	public function _example_output($output = null)
	{
		$this->load->view('example.php',$output);
	}

	public function offices()
	{
		$output = $this->grocery_crud->render();

		$this->_example_output($output);
	}

	public function index()
	{
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

	public function offices_management()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('offices');
			$crud->set_subject('Office');
			$crud->required_fields('city');
			$crud->columns('city','country','phone','addressLine1','postalCode');

			$output = $crud->render();

			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	public function employees_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('employees');
			$crud->set_relation('officeCode','offices','city');
			$crud->display_as('officeCode','Office City');
			$crud->set_subject('Employee');

			$crud->required_fields('lastName');

			$crud->set_field_upload('file_url','assets/uploads/files');

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function customers_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_table('customers');
			$crud->columns('customerName','contactLastName','phone','city','country','salesRepEmployeeNumber','creditLimit');
			$crud->display_as('salesRepEmployeeNumber','from Employeer')
				 ->display_as('customerName','Name')
				 ->display_as('contactLastName','Last Name');
			$crud->set_subject('Customer');
			$crud->set_relation('salesRepEmployeeNumber','employees','lastName');

			$output = $crud->render();

			$this->_example_output($output);
	}

    public function miembros()
    {
        $crud = new grocery_CRUD();

        $crud->set_model('Dojo_model');              // ------------ AGREGADO ------------ //
        $crud->set_table('miembros');
        $crud->columns('codmiembro','nombre','apellido','id_dojo','cargo','fechaingreso', 'estado');
        //$crud->columns('customerName','contactLastName','phone','city','country','salesRepEmployeeNumber','creditLimit');
        $crud->display_as('codmiembro',      'Código de Miembro')
            ->display_as('nombre',         'Nombre')
            ->display_as('apellido',       'Apellido')
            ->display_as('nummovil',       'Núm Móvil')
            ->display_as('id_dojo',           'Dojo')
            ->display_as('estado',         'Estado')
            ->display_as('fechaingreso',   'Fecha de Ingreso')
            ->display_as('fechareingreso', 'Fecha de Reingreso')
            ->display_as('cargo',          'Cargo')
            ->display_as('menor',          'Menor')
            ->display_as('9kyu',           '9 Kyu')
            ->display_as('5kyu',           '5 Kyu')
            ->display_as('4kyu',           '4 Kyu')
            ->display_as('3kyu',           '3 Kyu')
            ->display_as('2kyu',           '2 Kyu')
            ->display_as('1kyu',           '1 Kyu')
            ->display_as('1dan',           '1 Dan')
            ->display_as('2dan',           '2 Dan')
            ->display_as('3dan',           '3 Dan')
            ->display_as('4dan',           '4 Dan')
            ->display_as('aikikai',        'Aikikai #')
            ->display_as('registration',   'Registration #')
            ->display_as('numoficina',     'Núm Oficina')
            ->display_as('numcasa',        'Núm Casa')
            ->display_as('numpadre',       'Núm Padre')
            ->display_as('nummadre',       'Núm Madre')
            ->display_as('acudiente',      'Acudiente')
            ->display_as('centro',         'Centro de Labores o Estudio')
            ->display_as('direccion',      'Dirección Residencial')
            ->display_as('email',          'e-Mail')
            ->display_as('fechanac',       'Fecha de Nacimiento')
            ->display_as('edad',           'Edad')
            ->display_as('cumplemes',      'Cumple Mes')
            ->display_as('identificacion', 'Identificación')
            ->display_as('tiposangre',     'Tipo de Sangre')
            ->display_as('enfermedad',     'Enfermedad')
            ->display_as('alergicoa',      'Alergico a');

        $crud->field_type('cod_dojo','invisible');
        $crud->field_type('sec_dojo','invisible');


        $crud->set_relation('id_dojo','dojos','nombre');


        //$crud->set_relation('salesRepEmployeeNumber','employees','lastName');
        $crud->set_subject('Miembro');

        //$crud->callback_before_insert(array($this,'check_dojo'));

        $crud->callback_insert(array($this,'numero_miembro'));

        $output = $crud->render();
        $this->_example_output($output);
    }

    function numero_miembro($post_array) {

        $post_array["cod_dojo"]=$this->Dojo_model->get_cod_dojo($post_array["id_dojo"]);
        $post_array["sec_dojo"]=$this->Dojo_model->get_sec_dojo($post_array["id_dojo"]);
        $post_array["codmiembro"]=$post_array["cod_dojo"].str_pad($post_array["sec_dojo"],3,0,STR_PAD_LEFT);

        return $this->db->insert('miembros',$post_array);
    }


    function check_dojo($var)
    {
        //$crud = new grocery_CRUD();
        //$crud->set_model('custom_query_model');
        //$crud->set_table('employees'); //Change to your table name
        //$crud->basic_model->set_query_str('SELECT * FROM employees'); //Query text here
        //$output = $crud->render();

        /*$query = $this->db->select('codmiembro')
            ->like('codmiembro', 'ABPAPA', 'after')
            ->order_by('codmiembro', 'DESC')
            ->limit(1)
            ->get('miembros');*/

        //$dojopa = $this->Grocery_crud_model->check_PA();
        //$dojoch = $this->Grocery_crud_model->check_CH();
        //$dojoca = $this->Grocery_crud_model->check_CA();

        $dojopa = $this->Dojo_model->check_PA();

        //$dojopa = hcheck_PA();


        if( $var['dojo'] == 'Ciudad de Panamá, Panamá' ){

            /*public function consulta_PA(){
                $ask = $this->db->query("SELECT codmiembro FROM miembros WHERE codmiembro LIKE 'ABPACH%' ORDER BY codmiembro DESC LIMIT 1 ");
                //$crud = new grocery_CRUD();
                //$crud->where('nmiembro',1);
                //$crud->set_table('miembros');
                //$this->_example_output($output);
                //$output = $crud->render();
                //$salida = "muestrame";

                return $ask;
            }*/

            $var['codmiembro'] = 'ABPAPA - '.$dojopa.' - ultimo';
        }elseif( $var['dojo'] == 'David, Chiriquí'/* && $dojoch*/){
            $var['codmiembro'] = 'ABPACH '/*.$dojoch*/;
        }elseif( $var['dojo'] == 'Cartago, Costa Rica'/* && $dojoca*/){
            $var['codmiembro'] = 'ABPACA '/*.$dojoca*/;
        }
        return $var;
    }

    public function dojo_chiriqui()
    {
        $crud = new grocery_CRUD();

        $crud->set_table('dojo_chiriqui');
        $crud->columns('miembroch','nombre','apellido','dojo','cargo','fechaingreso', 'estado');
        $crud->display_as('miembroch',      'Miembro #')
            ->display_as('nombre',         'Nombre')
            ->display_as('apellido',       'Apellido')
            ->display_as('nummovil',       'Núm Móvil')
            ->display_as('dojo',           'Dojo')
            ->display_as('estado',         'Estado')
            ->display_as('fechaingreso',   'Fecha de Ingreso')
            ->display_as('fechareingreso', 'Fecha de Reingreso')
            ->display_as('cargo',          'Cargo')
            ->display_as('menor',          'Menor')
            ->display_as('9kyu',           '9 Kyu')
            ->display_as('5kyu',           '5 Kyu')
            ->display_as('4kyu',           '4 Kyu')
            ->display_as('3kyu',           '3 Kyu')
            ->display_as('2kyu',           '2 Kyu')
            ->display_as('1kyu',           '1 Kyu')
            ->display_as('1dan',           '1 Dan')
            ->display_as('2dan',           '2 Dan')
            ->display_as('aikikai',        'Aikikai #')
            ->display_as('registration',   'Registration #')
            ->display_as('numoficina',     'Núm Oficina')
            ->display_as('numcasa',        'Núm Casa')
            ->display_as('numpadre',       'Núm Padre')
            ->display_as('nummadre',       'Núm Madre')
            ->display_as('acudiente',      'Acudiente')
            ->display_as('centro',         'Centro de Labores o Estudio')
            ->display_as('direccion',      'Dirección Residencial')
            ->display_as('email',          'e-Mail')
            ->display_as('fechanac',       'Fecha de Nacimiento')
            ->display_as('edad',           'Edad')
            ->display_as('cumplemes',      'Cumple Mes')
            ->display_as('identificacion', 'Identificación')
            ->display_as('tiposangre',     'Tipo de Sangre')
            ->display_as('enfermedad',     'Enfermedad')
            ->display_as('alergicoa',      'Alergico a');

        $crud->set_subject('Miembro Dojo Chiriquí');
        $output = $crud->render();
        $this->_example_output($output);
    }

    public function dojo_cartago()
    {
        $crud = new grocery_CRUD();

        $crud->set_table('dojo_cartago');
        $crud->columns('miembroca','nombre','apellido','dojo','cargo','fechaingreso', 'estado');
        $crud->display_as('miembroca',      'Miembro #')
            ->display_as('nombre',         'Nombre')
            ->display_as('apellido',       'Apellido')
            ->display_as('nummovil',       'Núm Móvil')
            ->display_as('dojo',           'Dojo')
            ->display_as('estado',         'Estado')
            ->display_as('fechaingreso',   'Fecha de Ingreso')
            ->display_as('fechareingreso', 'Fecha de Reingreso')
            ->display_as('cargo',          'Cargo')
            ->display_as('menor',          'Menor')
            ->display_as('9kyu',           '9 Kyu')
            ->display_as('5kyu',           '5 Kyu')
            ->display_as('4kyu',           '4 Kyu')
            ->display_as('3kyu',           '3 Kyu')
            ->display_as('2kyu',           '2 Kyu')
            ->display_as('1kyu',           '1 Kyu')
            ->display_as('1dan',           '1 Dan')
            ->display_as('2dan',           '2 Dan')
            ->display_as('aikikai',        'Aikikai #')
            ->display_as('registration',   'Registration #')
            ->display_as('numoficina',     'Núm Oficina')
            ->display_as('numcasa',        'Núm Casa')
            ->display_as('numpadre',       'Núm Padre')
            ->display_as('nummadre',       'Núm Madre')
            ->display_as('acudiente',      'Acudiente')
            ->display_as('centro',         'Centro de Labores o Estudio')
            ->display_as('direccion',      'Dirección Residencial')
            ->display_as('email',          'e-Mail')
            ->display_as('fechanac',       'Fecha de Nacimiento')
            ->display_as('edad',           'Edad')
            ->display_as('cumplemes',      'Cumple Mes')
            ->display_as('identificacion', 'Identificación')
            ->display_as('tiposangre',     'Tipo de Sangre')
            ->display_as('enfermedad',     'Enfermedad')
            ->display_as('alergicoa',      'Alergico a');

        $crud->set_subject('Miembro Dojo Cartago');
        $output = $crud->render();
        $this->_example_output($output);
    }

	public function orders_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_relation('customerNumber','customers','{contactLastName} {contactFirstName}');
			$crud->display_as('customerNumber','Customer');
			$crud->set_table('orders');
			$crud->set_subject('Order');
			$crud->unset_add();
			$crud->unset_delete();

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function products_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_table('products');
			$crud->set_subject('Product');
			$crud->unset_columns('productDescription');
			$crud->callback_column('buyPrice',array($this,'valueToEuro'));

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function valueToEuro($value, $row)
	{
		return $value.' &euro;';
	}

	public function film_management()
	{
		$crud = new grocery_CRUD();

		$crud->set_table('film');
		$crud->set_relation_n_n('actors', 'film_actor', 'actor', 'film_id', 'actor_id', 'fullname','priority');
		$crud->set_relation_n_n('category', 'film_category', 'category', 'film_id', 'category_id', 'name');
		$crud->unset_columns('special_features','description','actors');

		$crud->fields('title', 'description', 'actors' ,  'category' ,'release_year', 'rental_duration', 'rental_rate', 'length', 'replacement_cost', 'rating', 'special_features');

		$output = $crud->render();

		$this->_example_output($output);
	}

	public function film_management_twitter_bootstrap()
	{
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('twitter-bootstrap');
			$crud->set_table('film');
			$crud->set_relation_n_n('actors', 'film_actor', 'actor', 'film_id', 'actor_id', 'fullname','priority');
			$crud->set_relation_n_n('category', 'film_category', 'category', 'film_id', 'category_id', 'name');
			$crud->unset_columns('special_features','description','actors');

			$crud->fields('title', 'description', 'actors' ,  'category' ,'release_year', 'rental_duration', 'rental_rate', 'length', 'replacement_cost', 'rating', 'special_features');

			$output = $crud->render();
			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	function multigrids()
	{
		$this->config->load('grocery_crud');
		$this->config->set_item('grocery_crud_dialog_forms',true);
		$this->config->set_item('grocery_crud_default_per_page',10);

		$output1 = $this->offices_management2();

		$output2 = $this->employees_management2();

		$output3 = $this->customers_management2();

		$js_files = $output1->js_files + $output2->js_files + $output3->js_files;
		$css_files = $output1->css_files + $output2->css_files + $output3->css_files;
		$output = "<h1>List 1</h1>".$output1->output."<h1>List 2</h1>".$output2->output."<h1>List 3</h1>".$output3->output;

		$this->_example_output((object)array(
				'js_files' => $js_files,
				'css_files' => $css_files,
				'output'	=> $output
		));
	}

	public function offices_management2()
	{
		$crud = new grocery_CRUD();
		$crud->set_table('offices');
		$crud->set_subject('Office');

		$crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/multigrids")));

		$output = $crud->render();

		if($crud->getState() != 'list') {
			$this->_example_output($output);
		} else {
			return $output;
		}
	}

	public function employees_management2()
	{
		$crud = new grocery_CRUD();

		$crud->set_theme('datatables');
		$crud->set_table('employees');
		$crud->set_relation('officeCode','offices','city');
		$crud->display_as('officeCode','Office City');
		$crud->set_subject('Employee');

		$crud->required_fields('lastName');

		$crud->set_field_upload('file_url','assets/uploads/files');

		$crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/multigrids")));

		$output = $crud->render();

		if($crud->getState() != 'list') {
			$this->_example_output($output);
		} else {
			return $output;
		}
	}

	public function customers_management2()
	{
		$crud = new grocery_CRUD();

		$crud->set_table('customers');
		$crud->columns('customerName','contactLastName','phone','city','country','salesRepEmployeeNumber','creditLimit');
		$crud->display_as('salesRepEmployeeNumber','from Employeer')
			 ->display_as('customerName','Name')
			 ->display_as('contactLastName','Last Name');
		$crud->set_subject('Customer');
		$crud->set_relation('salesRepEmployeeNumber','employees','lastName');

		$crud->set_crud_url_path(site_url(strtolower(__CLASS__."/".__FUNCTION__)),site_url(strtolower(__CLASS__."/multigrids")));

		$output = $crud->render();

		if($crud->getState() != 'list') {
			$this->_example_output($output);
		} else {
			return $output;
		}
	}

}