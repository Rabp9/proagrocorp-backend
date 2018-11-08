<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Filesystem\File;

/**
 * Links Controller
 *
 * @property \App\Model\Table\LinksTable $Links
 *
 * @method \App\Model\Entity\Link[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LinksController extends AppController
{
    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['getHeader', 'getFooter']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() {
        $links = $this->Links->find();

        $this->set(compact('links'));
        $this->set('_serialize', ['links']);
    }

    public function getHeader() {
        $linksHeader = $this->Links->find()
            ->where(["estado_id" => 1, "ubicacion" => "header"]);

        $this->set(compact('linksHeader'));
        $this->set('_serialize', ['linksHeader']);
    }

    public function getFooter() {
        $linksFooter = $this->Links->find()
            ->where(["estado_id" => 1, "ubicacion" => "footer"]);

        $this->set(compact('linksFooter'));
        $this->set('_serialize', ['linksFooter']);
    }

    /**
     * View method
     *
     * @param string|null $id Link id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $link = $this->Links->get($id);

        $this->set('link', $link);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $link = $this->Links->newEntity();
        
        if ($this->request->is('post')) {
            $link = $this->Links->patchEntity($link, $this->request->getData());
            
            if ($this->request->getData('changed')) {
                $pathSrc = WWW_ROOT . "tmp" . DS;
                $fileSrc = new File($pathSrc . $link->imagen);
            
                $pathDst = WWW_ROOT . 'img' . DS . 'links' . DS;
                $link->imagen = $this->Random->randomFileName($pathDst, 'link-', $fileSrc->ext());
                
                $fileSrc->copy($pathDst . $link->imagen);
            }
            
            if ($this->Links->save($link)) {
                $code = 200;
                $message = 'El link fue guardado correctamente';
            } else {
                $errors = $link->errors();
                $code = 500;
                $message = 'El link no fue guardado correctamente';
            }
        }
        
        $this->set(compact('link', 'message', 'code', 'errors'));
        $this->set('_serialize', ['link', 'message', 'code', 'errors']);
    }
    
    public function previewImagen() {
        if ($this->request->is("post")) {
            $imagen = $this->request->data["file"];
            
            $pathDst = WWW_ROOT . "tmp" . DS;
            $ext = pathinfo($imagen['name'], PATHINFO_EXTENSION);
            $filename = 'link-' . $this->Random->randomString() . '.' . $ext;
           
            $filenameSrc = $imagen["tmp_name"];
            $fileSrc = new File($filenameSrc);
            if ($fileSrc->copy($pathDst . $filename)) {
                $code = 200;
                $message = 'El link fue subido correctamente';
            } else {
                $code = 500;
                $message = "El link no fue subido con éxito";
            }
            
            $this->set(compact("code", "message", "filename"));
            $this->set("_serialize", ["code", "message", "filename"]);
        }
    }
}
