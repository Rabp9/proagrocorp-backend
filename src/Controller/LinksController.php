<?php
namespace App\Controller;

use App\Controller\AppController;

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
        $this->set('_serialize', 'links');
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
    public function view($id = null)
    {
        $link = $this->Links->get($id, [
            'contain' => ['Estados']
        ]);

        $this->set('link', $link);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $link = $this->Links->newEntity();
        if ($this->request->is('post')) {
            $link = $this->Links->patchEntity($link, $this->request->getData());
            if ($this->Links->save($link)) {
                $this->Flash->success(__('The link has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The link could not be saved. Please, try again.'));
        }
        $estados = $this->Links->Estados->find('list', ['limit' => 200]);
        $this->set(compact('link', 'estados'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Link id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $link = $this->Links->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $link = $this->Links->patchEntity($link, $this->request->getData());
            if ($this->Links->save($link)) {
                $this->Flash->success(__('The link has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The link could not be saved. Please, try again.'));
        }
        $estados = $this->Links->Estados->find('list', ['limit' => 200]);
        $this->set(compact('link', 'estados'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Link id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $link = $this->Links->get($id);
        if ($this->Links->delete($link)) {
            $this->Flash->success(__('The link has been deleted.'));
        } else {
            $this->Flash->error(__('The link could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
