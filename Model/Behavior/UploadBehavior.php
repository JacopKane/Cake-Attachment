<?php
App::uses('AppModel', 'Model');
App::uses('AttachmentBehavior', 'Uploader.Model/Behavior');

/**
 * Picture Model
 *
 * @property Vote $Vote
 */

class Picture extends AppModel {
/**
 * Display field
 *
 * @var string
 */
  public $displayField = 'name';
  
  public $actsAs = array(
    'Attachment.Upload' => array(
      'attachment' => array(
        'dir'       => 'img/media',
        'thumbsizes'  => array(
          'panel'   => array('width' => 600, 'height' => 600, 'name' =>  'panel.{$file}.{$ext}', 'crop' => true),
          'gallery' => array('width' => 140, 'height' => 93, 'name' => 'gallery.{$file}.{$ext}', 'crop' => true),
          'camera'  => array('width' => 400, 'height' => 300, 'name' =>  'camera.{$file}.{$ext}', 'crop' => true),
          'other'   => array('width' => 230, 'height' => 170, 'name' =>  'other.{$file}.{$ext}', 'crop' => true),
          'large'   => array('width' => 720, 'height' => 'auto', 'name' =>  'large.{$file}.{$ext}')
        )
      )
    )
  );
  
/**
 * Validation rules
 *
 * @var array
 */ 
 
 public $validate = array(
   'attachment' => array(
     'notEmpty' => array(
       'rule' => 'requiredFile',
       'message' => 'File required',
       'on' => 'create'
     ),
     'validUpload' => array (
       'rule' => array('validateUploadedFile'),
       'message' => 'Invalid file'
     ),
     'validExtension' => array (
       'rule' => array('validateFileExtension', array('jpg', 'jpeg', 'png', 'gif')),
       'message' => 'Invalid file: upload only jpg, png or gif'
     ),
     'maxFileSize' => array(
       'rule' => array('maxFileSize', 9999999999),
      'message' => 'File is too big'
     )
   )
 );

/**
 * hasMany associations
 *
 * @var array
 */
  public $hasMany = array(
    'Vote' => array(
      'className' => 'Vote',
      'foreignKey' => 'picture_id',
      'dependent' => false,
      'conditions' => '',
      'fields' => '',
      'order' => '',
      'limit' => '',
      'offset' => '',
      'exclusive' => '',
      'finderQuery' => '',
      'counterQuery' => ''
    )
  );

  public function beforeValidate($options = array()) {
    //debug($this->data);
    //exit();
    return parent::beforeValidate($options);
  }

  public function __construct($config) {
    $this->actsAs['Attachment.Upload']['attachment']['dir'] = Configure::read('Environment.Paths.app_webroot') . DS . $this->actsAs['Attachment.Upload']['attachment']['dir'];
    return parent::__construct($config);
  }

}
