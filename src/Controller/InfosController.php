<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Filesystem\File;

/**
 * Infos Controller
 *
 * @property \App\Model\Table\InfosTable $Infos
 *
 * @method \App\Model\Entity\Info[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InfosController extends AppController
{
    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['getMany', 'indexAdmin']);
    }
    
    /**
     * GetMany method
     *
     * @param string|null $descripciones.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function getMany($descripciones = null) {
        $descripciones = $this->request->data;
        $infos = array();
        
        if ($this->request->is('post')) {
            foreach ($descripciones as $descripcion) {
                $valor = $this->Infos->find()
                    ->where(['descripcion' => $descripcion])
                    ->first()->valor;
                $infos[$descripcion] = $valor;
            }
        }
        
        $this->set(compact('infos'));
        $this->set('_serialize', ['infos']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function indexAdmin($descripciones = null) {
        $descripciones = $this->request->data;
        $infos = array();
        
        if ($this->request->is('post')) {
            foreach ($descripciones as $descripcion) {
                $info = $this->Infos->find()
                    ->where(['descripcion' => $descripcion])
                    ->first();
                $infos[] = $info;
            }
        }
        
        $this->set(compact('infos'));
        $this->set('_serialize', ['infos']);
    }

    /**
     * View method
     *
     * @param string|null $id Info id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $info = $this->Infos->get($id, [
            'contain' => []
        ]);

        $this->set('info', $info);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        if ($this->request->is('post')) {
            $info = $this->Infos->newEntity($this->request->getData());
            
            if ($info->tipo == 'image' && $info->changed == true) {
                $pathSrc = WWW_ROOT . "tmp" . DS;
                $fileSrc = new File($pathSrc . $info->valor);
             
                $pathDst = WWW_ROOT . 'img' . DS . 'infos' . DS;
                $info->valor = $this->Random->randomFileName($pathDst, $info->descripcion . '-', $fileSrc->ext());
                
                $fileSrc->copy($pathDst . $info->valor);
            }
            
            if ($this->Infos->save($info)) {
                $code = 200;
                $message = 'La información fue guardada correctamente';
            } else {
                $message = 'La información no fue guardada correctamente';
            }
        }
        
        $this->set(compact('info', 'message', 'code'));
        $this->set('_serialize', ['info', 'message', 'code']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Info id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $info = $this->Infos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $info = $this->Infos->patchEntity($info, $this->request->getData());
            if ($this->Infos->save($info)) {
                $this->Flash->success(__('The info has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The info could not be saved. Please, try again.'));
        }
        $this->set(compact('info'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Info id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $info = $this->Infos->get($id);
        if ($this->Infos->delete($info)) {
            $this->Flash->success(__('The info has been deleted.'));
        } else {
            $this->Flash->error(__('The info could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
     
    public function previewImagen() {
        if ($this->request->is("post")) {
            $imagen = $this->request->data["file"];
            
            $pathDst = WWW_ROOT . "tmp" . DS;
            $ext = pathinfo($imagen['name'], PATHINFO_EXTENSION);
            $filename = 'imagen-' . $this->Random->randomString() . '.' . $ext;
           
            $filenameSrc = $imagen["tmp_name"];
            $fileSrc = new File($filenameSrc);
            if ($fileSrc->copy($pathDst . $filename)) {
                $code = 200;
                $message = 'La imagen fue subida correctamente';
            } else {
                $message = "La imagen no fue subida con éxito";
            }
            
            $this->set(compact("code", "message", "filename"));
            $this->set("_serialize", ["code", "message", "filename"]);
        }
    }
}