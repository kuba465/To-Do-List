<?php


class A implements \JsonSerializable {
    protected $name;
    protected $users;

    /**
     * A constructor.
     * @param $name
     * @param $users
     */
    public function __construct($name, $users)
    {
        $this->name = $name;
        $this->users = $users;
    }

    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'users' => $this->users,
        ];
    }
}

class User implements \JsonSerializable
{

    protected $name;
    protected $pass;

    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'pass' => $this->pass,
        ];
    }

    /**
     * User constructor.
     * @param $name
     * @param $pass
     */
    public function __construct($name, $pass)
    {
        $this->name = $name;
        $this->pass = $pass;
    }


}

$a = new A('ADIIAOSDISO', [
    new User('aaaa', 'jsdjhdsfh'),
    new User('nasdnsand', 'sdjhasdjhkjash'),
]);

echo json_encode($a);
