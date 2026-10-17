<?php

// Lab 2C: Constructors, Constants, and Inheritance

echo '<h1>Lab 2C: User and Tutor Classes</h1>';

function cleanText($value)
{
    // TODO: Return the value with extra spaces removed.
    return trim($value);
}

class User
{
    public const STATUS_ACTIVE = 'active';

    public $name;
    public $email;
    public $status;

    public function __construct($name, $email)
    {
        // TODO: Clean and store the name.
        // TODO: Clean, lowercase, and store the email.
        // TODO: Assign STATUS_ACTIVE to status.

        $this->name = cleanText($name);
        $this->email = strtolower(cleanText($email));
        $this->status = self::STATUS_ACTIVE;
        
    }    
}

class Tutor extends User
{
    public $subject;

    public function __construct($name, $email, $subject)
    {
        // TODO: Call the parent constructor.
        // TODO: Clean and store the subject.

        parent::__construct($name,$email);
        $this->subject = cleanText($subject);
    }

    public function profileSummary()
    {
        // TODO: Return the tutor's name, email, and subject.
        return $this->name . ' (' . $this->email . ') ' .
                ' - Tutor for ' . $this->subject;
    }
}

// TODO: Create a Tutor object using sample data.
// TODO: Display profileSummary().

$tutor = new Tutor('  Jordan Lee  ','JLEE@EXAMPLE.COM', 'PHP');
echo $tutor->profileSummary();