<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\ORM\TableRegistry;

/**
 * Slides Controller
 *
 * @property \App\Model\Table\SlidesTable $Slides
 *
 * @method \App\Model\Entity\Slide[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SlidesController extends AppController
{

    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['index']);
    }
    
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $slides = $this->Slides->find()
            ->where(['estado_id' => 1])
            ->select(['id', 'imagen'])
            ->order(['orden' => 'ASC']);
                
        $this->set(compact('slides'));
        $this->set('_serialize', ['slides']);
    }
    
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function getAdmin() {        
        $slides = $this->Slides->find()
            ->order(['orden' => 'ASC']);
                
        $this->set(compact('slides'));
        $this->set('_serialize', ['slides']);
    }
    
    /**
     * View method
     *
     * @param string|null $id Slide id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $slide = $this->Slides->get($id);
        $this->set(compact('slide'));
        $this->set('_serialize', ['slide']);
    }
    
    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $slide = $this->Slides->newEntity();
        
        if ($this->request->is('post')) {
            $slide = $this->Slides->patchEntity($slide, $this->request->getData());
            
            if ($slide->imagen) {
                $path_src = WWW_ROOT . "tmp" . DS;
                $file_src = new File($path_src . $slide->imagen);
             
                $path_dst = WWW_ROOT . 'img' . DS . 'slides' . DS;
                $slide->imagen = $this->Random->randomFileName($path_dst, 'slide-', $file_src->ext());
                
                $file_src->copy($path_dst . $slide->imagen);
            }
            
            if ($this->Slides->save($slide)) {
                $code = 200;
                $message = 'El slide fue guardado correctamente';
            } else {
                $message = 'El slide no fue guardado correctamente';
            }
        }
        
        $this->set(compact('slide', 'message', 'code'));
        $this->set('_serialize', ['slide', 'message', 'code']);
    }
    
    public function previewImagen() {        
        if ($this->request->is("post")) {
            $imagen = $this->request->data["file"];
            
            $pathDst = WWW_ROOT . "tmp" . DS;
            $ext = pathinfo($imagen['name'], PATHINFO_EXTENSION);
            $filename = 'slide-' . $this->Random->randomString() . '.' . $ext;
           
            $filenameSrc = $imagen["tmp_name"];
            $fileSrc = new File($filenameSrc);
            if ($fileSrc->copy($pathDst . $filename)) {
                $code = 200;
                $message = 'La imagen fue subida correctamente';
            } else {
                $message = "La imagen no fue subida con éxito";
            }
            
            $this->set(compact("code", "message", "filename"));
            $this->set("_serialize", ["message", "filename"]);
        }
    }
    
    public function saveMany() {
        $slides = $this->Slides->newEntities($this->request->getData('slides'));
        $r = true;
        foreach ($slides as $slide) {
            if (!$this->Slides->save($slide)) {
                $r = false;
            }
        }
        
        if ($r) {
            $code = 200;
            $message = 'El orden de los slides fueron guardados correctamente';
        } else {
            $message = 'El orden de los slides no fueron guardados correctamente';
        }
        
        $this->set(compact('slides', 'message', 'code'));
        $this->set('_serialize', ['slide', 'message', 'code']);
    }
}