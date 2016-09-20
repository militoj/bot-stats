<?php namespace Stats;

abstract class Tasks
{

    private $servername = "192.168.0.47";
    private $username = "root";
    private $password = "BPS4mysql";
    private $dbname = "bps";
    private $taskData = array();


    public function __construct()
    {
      // Create connection
      $conn = new \mysqli($this->servername, $this->username, $this->password, $this->dbname);
      // Check connection
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT tasks_type.task_type,
        count(tasks_type.task_type) as taskCount,
        patient_tasks.task_type_id,
        users.last_name,
        users.first_name,
        users.userid
        FROM tasks_type
        join patient_tasks on tasks_type.type_id=patient_tasks.task_type_id
        join users on users.userid=patient_tasks.task_user_id
        where tasks_type.task_type = '{$this->taskType}'
        group by users.userid
        order by users.last_name ASC";
        $this->tasks = $conn->query($sql);
        }

      public function byUserId($userid)
      {
        $userTaskData = $this->all();
        if (in_array($userid, array_keys($userTaskData)))
        {
          return $userTaskData[$userid]['taskCount'];
        }
        return 0;

      }

      public function userData($userid){
          $temp = array();
          $userTaskData = $this->all();
          $temp['lastname'] = $userTaskData[$userid]['last_name'];
          $temp['firstname'] = $userTaskData[$userid]['first_name'];
          $temp['userid'] = $userTaskData[$userid]['userid'];
          return $temp;

      }

      public function all()
      {
        if (count($this->taskData) >0){
          return $this->taskData;
        }
        $userTaskData = array();
        while($row = $this->tasks->fetch_assoc())
        {
          $userTaskData[$row["userid"]] = $row;
        }
        $this->taskData = $userTaskData;
        return $userTaskData;
      }
}
