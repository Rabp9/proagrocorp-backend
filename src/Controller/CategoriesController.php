<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Hash;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 *
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CategoriesController extends AppController
{
    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['view', 'index']);
    }
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() {
        $estado_id = $this->request->getQuery('estado_id');
        $this->Categories->recover();
        
        $query = $this->Categories->find()
            ->contain(['Child1Categories' => ['Child2Categories']])
            ->where(['parent_id IS' => null]);
        
        if ($estado_id) {
            $query->where(['Categories.estado_id' => $estado_id]);
        }
        
        $categories = $query->toArray();
        
        $this->set(compact('categories'));
        $this->set('_serialize', ['categories']);
    }
    
    /**
     * getAdmin method
     *
     * @return \Cake\Http\Response|void
     */
    public function getAdmin() {
        $this->Categories->recover();
        
        $categories = $this->Categories->find()
            ->contain(['Child1Categories' => ['Child2Categories']])
            ->where(['parent_id IS' => null, 'estado_id' => 1]);
        
        $this->set(compact('categories'));
        $this->set('_serialize', ['categories']);
    }
    
    /**
     * View method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $category = $this->Categories->get($id, [
            'contain' => ['Productos', 'ParentCategories1' => ['ParentCategories2']]
        ]);
        
        $this->set(compact('category'));
        $this->set('_serialize', ['category']);
    }
    
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $category = $this->Categories->newEntity();
        
        if ($this->request->is('post')) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());
            
            if ($category->portada) {
                $pathSrc = WWW_ROOT . "tmp" . DS;
                $fileSrc = new File($pathSrc . $category->portada);
             
                $pathDst = WWW_ROOT . 'img' . DS . 'categories' . DS;
                $category->portada= $this->Random->randomFileName($pathDst, 'category-', $fileSrc->ext());
                
                $fileSrc->copy($pathDst . $category->portada);
            }
            
            if ($this->Categories->save($category)) {
                $code = 200;
                $message = 'La categoría fue guardado correctamente';
            } else {
                $message = 'La categoría no fue guardado correctamente';
            }
        }
        
        $this->set(compact('category', 'message', 'code'));
        $this->set('_serialize', ['category', 'message', 'code']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The category could not be saved. Please, try again.'));
        }
        $categories = $this->Categories->Categories->find('list', ['limit' => 200]);
        $estados = $this->Categories->Estados->find('list', ['limit' => 200]);
        $this->set(compact('category', 'categories', 'estados'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $category = $this->Categories->get($id);
        if ($this->Categories->delete($category)) {
            $this->Flash->success(__('The category has been deleted.'));
        } else {
            $this->Flash->error(__('The category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    /**
     * Get Tree List method
     *
     * @return \Cake\Network\Response|null
     */
    public function getTreeList($spacer = null) {
        $spacer = $this->request->getParam('spacer');
        
        $this->Categories->recover();
        $categoriesPre = $this->Categories->find()
            ->where(['estado_id' => 1])
            ->select(['id', 'lft', 'rght', 'descripcion'])
            ->order(['lft' => 'ASC'])
            ->toArray();
        
        for ($i = 0; $i < sizeof($categoriesPre); $i++) {
            if ($i != 0) {
                $v_current = $categoriesPre[$i];
                for ($j = $i - 1; $j >= 0; $j--) {
                    $v_compare = $categoriesPre[$j];
                    if ($v_current->lft < $v_compare->rght) {
                        $categoriesPre[$i]->descripcion = $spacer . $categoriesPre[$i]->descripcion;
                    }
                }
            }
        }
        $categories = [];
        for ($i = 0; $i < sizeof($categoriesPre); $i++) {
            if (strpos($categoriesPre[$i]->descripcion, $spacer . $spacer) != 'false') {
                $categories[] = $categoriesPre[$i];
            }
        }
        
        $this->set(compact('categories'));
        $this->set('_serialize', ['categories']);
    }
    
    public function previewPortada() {
        if ($this->request->is("post")) {
            $portada = $this->request->data["file"];
            
            $pathDst = WWW_ROOT . "tmp" . DS;
            $ext = pathinfo($portada['name'], PATHINFO_EXTENSION);
            $filename = 'category-' . $this->Random->randomString() . '.' . $ext;
            
            $filenameSrc = $portada["tmp_name"];
            $fileSrc = new File($filenameSrc);
            if ($fileSrc->copy($pathDst . $filename)) {
                $code = 200;
                $message = 'La portada fue subida correctamente';
            } else {
                $message = "La portada no fue subida con éxito";
            }
            
            $this->set(compact("code", "message", "filename"));
            $this->set("_serialize", ["message", "filename"]);
        }
    }
}
