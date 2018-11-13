<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Filesystem\File;

/**
 * Productos Controller
 *
 * @property \App\Model\Table\ProductosTable $Productos
 *
 * @method \App\Model\Entity\Producto[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductosController extends AppController
{
    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['view', 'index', 'getRelacionados']);
    }
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() {
        $estado_id = $this->request->query('estado_id');
        $text = $this->request->query('text');
        $category_id = $this->request->query('category_id');
        $items_per_page = $this->request->query('items_per_page');
        
        $this->paginate = [
            'limit' => $items_per_page
        ];
        
        $query = $this->Productos->find()
            ->contain(['Categories'])
            ->order(['Productos.id' => 'ASC']);
        
        if ($text) {
            $query->where(['OR' => [
                'Productos.descripcion LIKE' => '%' . $text . '%',
                'Productos.nombre2 LIKE' => '%' . $text . '%',
                'Productos.nombre3 LIKE' => '%' . $text . '%'
            ]]);
        }
        
        if ($category_id) {
            $query->where(['Productos.category_id' => $category_id]);
        }
        
        if ($estado_id) {
            $query->where(['Productos.estado_id' => $estado_id]);
        }
        
        $productos = $this->paginate($query);
        $paginate = $this->request->param('paging')['Productos'];
        $pagination = [
            'totalItems' => $paginate['count'],
            'itemsPerPage' =>  $paginate['perPage']
        ];
        
        $this->set(compact('productos', 'pagination'));
        $this->set('_serialize', ['productos', 'pagination']);
    }
    
    /**
     * View method
     *
     * @param string|null $id Producto id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $producto = $this->Productos->get($id, [
            'contain' => ['Categories' => ['ParentCategories1' => ['ParentCategories2']]]
        ]);

        $this->set(compact('producto'));
        $this->set('_serialize', ['producto']);
    }

    public function previewImagen() {
        if ($this->request->is("post")) {
            $imagen = $this->request->data["file"];
            
            $pathDst = WWW_ROOT . "tmp" . DS;
            $ext = pathinfo($imagen['name'], PATHINFO_EXTENSION);
            $filename = 'producto-' . $this->Random->randomString() . '.' . $ext;
           
            $filenameSrc = $imagen["tmp_name"];
            $fileSrc = new File($filenameSrc);
            if ($fileSrc->copy($pathDst . $filename)) {
                $code = 200;
                $message = 'El producto fue subido correctamente';
            } else {
                $code = 500;
                $message = "El producto no fue subido con éxito";
            }
            
            $this->set(compact("code", "message", "filename"));
            $this->set("_serialize", ["code", "message", "filename"]);
        }
    }
    
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $producto = $this->Productos->newEntity();
        
        if ($this->request->is('post')) {
            $producto = $this->Productos->patchEntity($producto, $this->request->getData());
            
            if ($this->request->getData('changed')) {
                $pathSrc = WWW_ROOT . "tmp" . DS;
                $fileSrc = new File($pathSrc . $producto->imagen);
            
                $pathDst = WWW_ROOT . 'img' . DS . 'productos' . DS;
                $producto->imagen = $this->Random->randomFileName($pathDst, 'producto-', $fileSrc->ext());
                
                $fileSrc->copy($pathDst . $producto->imagen);
            }
            
            if ($this->Productos->save($producto)) {
                $code = 200;
                $message = 'El producto fue guardado correctamente';
            } else {
                $errors = $producto->errors();
                $code = 500;
                $message = 'El producto no fue guardado correctamente';
            }
        }
        
        $this->set(compact('producto', 'message', 'code', 'errors'));
        $this->set('_serialize', ['producto', 'message', 'code', 'errors']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function getRelacionados() {
        $producto_id = $this->request->param("producto_id");
        $producto = $this->Productos->get($producto_id);
        
        $productos = $this->Productos->find()->where([
            "Productos.category_id" => $producto->category_id,
            "Productos.id !=" => $producto->id 
        ]);
                
        $this->set(compact('productos'));
        $this->set('_serialize', ['productos']);
    }
}
