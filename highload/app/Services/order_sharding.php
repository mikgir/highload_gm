<?php
/**
* Order
*  - id: int
*  - name: varchar
*  - date: datetime
*  - user_id: int
*  - sum: float
*/

class Order {
     public $id;
     public $name;
     public $date;
     public $user_id;
     public $sum;

     public function __construct($name, $date, $user_id, $sum) {
          $this->name = $name;
          $this->date = $date;
          $this->user_id = $user_id;
          $this->sum = $sum;
     }
}

class OrderStorage implements OrderStorageInterface
{

    public function __construct(private ShardingStragegyInterace $shardingStragegy)
    {
    }

    protected function runQuery($query, Order $order) {
        /** @var PDO $connection */
         $connection = $this->shardingStragegy->getConnection($order);
         $connection->query($query);
     }

     public function insert(Order $order) {
          //добавить запись и вернуть объект с id
          $this->runQuery("insert lalalal", $order);
          return mysql_insert_id();
     }

     public function update(Order $order) {
          //обновить объект
          $this->runQuery("update lalala", $order);
     }

     public function delete(Order $order) {
          //удалить объект
          $this->runQuery("delete lalalal", $order);
     }
}

class ShardingStragegy implements ShardingStragegyInterace
{
    protected static $instance = null;
    protected PDO $server1;
    protected PDO $server2;

    public function __construct() {
         $this->server1 = new PDO(
             'mysql:dbname=highload;host=mariadb-shard-1',
             'root',
             'xSc1jnBR6r8GW9gQgNvdKsVqGDqm5l'
         );

        $this->server2 = new PDO(
            'mysql:dbname=highload;host=mariadb-shard-2',
            'root',
            'xSc1jnBR6r8GW9gQgNvdKsVqGDqm5l'
        );
    }

    public function getConnection(Order $order): PDO
    {
         return $order->user_id % 2 == 0 ? $this->server1 : $this->server2;
    }
}

$storage = new OrderStorage();

$someOrder = new Order('test order1', date('Ymd'), 1, 100);
$storage->insert($someOrder);
