<?php 
  require (APPPATH.'/libraries/REST_Controller.php');
  class Books extends \Restserver\Libraries\REST_Controller
  {
      public function __construct(){
        parent::__construct();
      $this->load->model('boardsystem_model');
      $this->load->helper('url');
      session_start();
      
    }
   public function index_get($id)
    {
      
      if(!$id){
        $this->response('',404);
        
      }else{
      switch ($id){
        case 1:{
          //echo 'book1';
          $Aid='00101';
          $Bid='00001';
          $cc = $this->boardsystem_model->ShowPost($Bid,$Aid);
         
          foreach($cc[0] as $key => $value){
            //print_r($value);
            $new_array[urlencode($key)] = urlencode($value);
          }
          $ans=json_encode($new_array, JSON_NUMERIC_CHECK|JSON_UNESCAPED_UNICODE);
          
          $final=urldecode($ans);
          $gg=json_decode($final);
          $cc= $gg->main;
          //echo $cc;
         // echo json_decode($cc);
          $data['aa']='animación';
          
          $this->response($data,201);
         // print_r($final);
         
         
         //echo $ans;
          //print_r($cc);
          break;
        }
        case 2:{
          echo 'book2';
          break;
        }
        case 3:{
          echo 'book3';
          break;
        }
      }
        
      
      }

    
        
    }
        
     
      // Display all books
    

    public function index_post()
    {
      // Create a new book
    }

    public function gg_get()
    {
      // Create a new book
      //$gg="gg";
      $this->response(array('error' => 'Couldn\'t find any widgets!'), 404);
    }
    function user_get()
    {
        $data = array('returned: '. $this->get('id'));
        $this->response($data);
    }

    function showall_get(){
      print 'books';
    }

    //test//
    function jack_get($id){
      switch($id){
        case  1:{
          print "get book1";
          break;
        }
        case  2:{
          print "get book2";
          break;
        }
        case  3:{
          print "get book3";
          break;
        }
      }
    }
    function jack_post($id){
      switch($id){
        case  1:{
          print "post book1";
          break;
        }
        case  2:{
          print "post book2";
          break;
        }
        case  3:{
          print "post book3";
          break;
        }
      }
    }
    function jack_put($id){
      switch($id){
        case  1:{
          print "update book1";
          break;
        }
        case  2:{
          print "update book2";
          break;
        }
        case  3:{
          print "update book3";
          break;
        }
      }
    }
    function jack_delete($id){
      switch($id){
        case  1:{
          print "del book1";
          break;
        }
        case  2:{
          print "del book2";
          break;
        }
        case  3:{
          print "del book3";
          break;
        }
      }
    }

    function jacks_get(){
      print 'get books';
    }

    function jacks_post(){
      print 'post books';
    }
    function jacks_put(){
      print 'put books';
    }
    function jacks_delete(){
      print 'delete books';
    }

    
}
?>