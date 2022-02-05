<?php

class pseudocrud
{
	private static $_db = array();

	public static function create($value_dictionary)
    {
        $c = count(Self::$_db);

        $new_id = $c + 1;

        $new_object = $value_dictionary;
        $new_object['id'] = $new_id;

        Self::$_db[] = $new_object;

        return $new_id;
    }

    public static function read($id)
    {
        $object_found = null;

        foreach (Self::$_db as $obj)
        {
            if ($obj['id'] == $id)
            {
                $object_found = $obj;
                return $object_found;
            }
        }
        return $object_found;
    }

    public static function read_by($key, $value)
    {
        $objects_found = array();

        foreach (Self::$_db as $obj)
        {
            if ($obj[$key] == $value)
            {
                $objects_found[] = $obj;
            }
        }
        return $objects_found;
    }

    public static function read_all()
    {
        return Self::$_db;
    }

    public static function update($id, $value_dictionary)
    {
        $update = false;
        $c = count(Self::$_db);

        for ($i = 0; $i < $c; ++$i)
        {
            if (Self::$_db[$i]['id'] == $id)
            {
                foreach ($value_dictionary as $key => $value)
                {
                    Self::$_db[$i][$key] = $value;
                }
                $update = true;
                return $update;
            }
        }

        return $update;
    }

    public static function delete($id)
    {
        $deleted = false;
        $c = count(Self::$_db);

        for ($i = 0; $i < $c; ++$i)
        {
            if (Self::$_db[$i]['id'] == $id)
            {
                unset(Self::$_db[$i]);
                $deleted = true;
                return $deleted;
            }
        }
        return $deleted;
    }

    public static function view()
    {
        $json_representative = json_encode(Self::$_db);

        return $json_representative;
    }

}

//create examples
$new_id = pseudocrud::create([
    'username' => 'a_username',
    'email' => 'some@email',
    'name' => 'John Q. Citizen',
    'password' => 'some_password'
]);

$another_new_id = pseudocrud::create([
    'username' => 'another_username',
    'email' => 'another@email',
    'name' => 'Jane Doe',
    'password' => 'some_other_password'
]);

//create test

/*
    Checking to see if a user with an email of 'some@email' was created using the static read_by method of the pseudocrud class
*/

$read_by = pseudocrud::read_by('email', 'some@email');
if(count($read_by) > 0){
    echo 'Pseudo create method works properly';
}else{
    echo 'Psuedo create method did not worked properly';
}
echo '<br><br>';

/*
    Checking to see if a user with an username of 'another_username' was created using the static read_by method of the pseudocrud class
*/

$read_by_2 = pseudocrud::read_by('username', 'another_username');

if(count($read_by_2) > 0){
    echo 'Pseudo create method works properly';
}else{
    echo 'Psuedo create method did not worked properly';
}
echo '<br><br>';


//read test

/*
    To test the read method I passed the id of 1 and then 2, because both users created above are supposed to have those ids respectively,
    If we don't get a valid response from passing 1 and then 2, it means the read function does not work properly
*/

$read_1 = pseudocrud::read(1);
$read_2 = pseudocrud::read(2);
print_r($read_1);
echo '<br><br>';
print_r($read_2);
echo '<br><br>';

//read_by test

/*
    The read_by method was used to test the create method above, 
    so I am just going to do a further check, by simply checking for tha value that was used to search.
*/

$read_by = pseudocrud::read_by('email', 'some@email');

foreach($read_by as $each){
    if(isset($each['email']) && $each['email'] == 'some@email'){
        echo 'Pseudo Read By Method works properly';
        break;
    }
    echo 'Pseudo Read By Method does not working properly properly';
}
echo '<br><br>';

$read_by_2 = pseudocrud::read_by('username', 'another_username');

foreach($read_by_2 as $each){
    if(isset($each['username']) && $each['username'] == 'another_username'){
        echo 'Pseudo Read By Method works properly';
        break;
    }
    echo 'Pseudo Read By Method does not working properly properly';
}
echo '<br><br>';

//update tes
/*
    In this case I am going to update some values of the users in the psuedo class,
    and then check if the update were being made.
*/
pseudocrud::update(1, ['name' => 'Femi Fatokun']);
$read_1 = pseudocrud::read(1);
if($read_1['name'] != 'Femi Fatokun'){
    echo 'Pseudo Update method not working properly';
}else{
    echo 'Pseudo Update method works properly';
}
echo '<br><br>';


pseudocrud::update(2, ['name' => 'Mr Stephen']);
$read_2 = pseudocrud::read(2);
if($read_2['name'] != 'Mr Stephen'){
    echo 'Pseudo Update method not working properly';
}else{
    echo 'Pseudo Update method works properly';
}
echo '<br><br>';

//delete test

pseudocrud::delete(1);

$read_1 = pseudocrud::read(1);

if($read_1 == null){
    echo 'Pseudo Delete method works properly';
}else{
    echo 'Pseudo Delete method not working properly';
}
echo '<br><br>';

//view
echo 'You have ' . count(pseudocrud::read_all()) . ' users: ';
echo pseudocrud::view();
?>