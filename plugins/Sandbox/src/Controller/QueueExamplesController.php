<?php
namespace Sandbox\Controller;

use Tools\Utility\Time;

/**
 * @property \Queue\Model\Table\QueuedJobsTable $QueuedJobs
 * @property \Queue\Model\Table\QueueProcessesTable $QueueProcesses
 */
class QueueExamplesController extends SandboxAppController {

	/**
	 * @var string
	 */
	public $modelClass = 'Queue.QueuedJobs';

	/**
	 * @var array
	 */
	public $components = [];

	/**
	 * @var array
	 */
	public $helpers = [];

	/**
	 * @return void
	 */
	public function initialize() {
		parent::initialize();
	}

	/**
	 * @return void
	 */
	public function index() {
		// For the demo we bind it to the user session to avoid other people testing it to have side-effects :)
		$sid = $this->request->getSession()->id();

		$queuedJobs = $this->QueuedJobs->find()->where(['reference LIKE' => 'demo-' . $sid, 'completed IS' => null])->all()->toArray();

		$this->set(compact('queuedJobs'));
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function scheduling() {
		$tasks = ['Example' => 'Example', 'ProgressExample' => 'ProgressExample'];

		// For the demo we bind it to the user session to avoid other people testing it to have side-effects :)
		$sid = $this->request->getSession()->id();
		$queuedJob = $this->QueuedJobs->newEntity();

		if ($this->request->is('post')) {
			$queuedJob = $this->QueuedJobs->patchEntity($queuedJob, $this->request->getData());
			$notBefore = $queuedJob->notbefore;
			$task = $queuedJob->task;

			if (!$task || !isset($tasks[$task])) {
				$queuedJob->setError('task', 'Required field.');
			}
			if (!$notBefore || !$notBefore->isFuture()) {
				$queuedJob->setError('notbefore', 'Invalid value.');
			}

			if (!$queuedJob->getErrors()) {
				if ($this->scheduleDelayedDemo($task, $notBefore)) {
					$this->Flash->success('Scheduled ' . $task . ' for ' . $notBefore . ' (' . Time::relLengthOfTime($notBefore) . '). Check again at that time.');

					return $this->redirect(['action' => 'scheduling']);
				}

				$this->Flash->error('There is already a task scheduled. Please wait.');

			} else {
				$this->Flash->error('Please correct the errors to continue.');
			}
		}

		$queuedJobs = $this->QueuedJobs->find()->where(['reference LIKE' => 'scheduling-' . $sid, 'completed IS' => null])->all()->toArray();

		$this->set(compact('queuedJobs', 'queuedJob', 'tasks'));
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function config() {
		$this->loadModel('Queue.QueueProcesses');
		$status = $this->QueueProcesses->status();

		$length = $this->QueuedJobs->getLength();

		$this->set(compact('status', 'length'));
	}

	/**
	 * @return \Cake\Http\Response|null
	 */
	public function scheduleDemo() {
		$this->request->allowMethod('post');

		// For the demo we bind it to the user session to avoid other people testing it to have side-effects :)
		$sid = $this->request->getSession()->id();

		$seconds = 20;
		$reference = 'demo-' . $sid;
		if ($this->QueuedJobs->isQueued($reference, 'ProgressExample')) {
			$this->Flash->error('Job already running. Refresh the page for details.');

			return $this->redirect($this->referer(['action' => 'index']));
		}

		$this->QueuedJobs->createJob(
			'ProgressExample',
			['duration' => $seconds],
			['reference' => $reference]
		);

		$this->Flash->success('Queued: ProgressExample with ' . $seconds . 's long job.');

		return $this->redirect($this->referer(['action' => 'index']));
	}

	/**
	 * @param string $task
	 * @param \Cake\I18n\FrozenTime $notBefore
	 * @return bool
	 */
	protected function scheduleDelayedDemo($task, $notBefore) {
		// For the demo we bind it to the user session to avoid other people testing it to have side-effects :)
		$sid = $this->request->getSession()->id();

		$reference = 'scheduling-' . $sid;

		if ($this->QueuedJobs->isQueued($reference, $task)) {
			return false;
		}

		$data = [];
		if ($task === 'ProgressExample') {
			$data = [
				'duration' => 10
			];
		}

		$this->QueuedJobs->createJob(
			$task,
			$data,
			['reference' => $reference, 'notBefore' => $notBefore]
		);

		return true;
	}

}