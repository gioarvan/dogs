<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Validation Language Lines
      |--------------------------------------------------------------------------
      |
      | The following language lines contain the default error messages used
      | by the validator class. Some of the rules contain multiple versions,
      | such as the size (max, min, between) rules. These versions are used
      | for different input types such as strings and files.
      |
      | These language lines may be easily changed to provide custom error
      | messages in your application. Error messages for custom validation
      | rules may also be added to this file.
      |
     */

    "accepted" => "The :attribute must be accepted.",
    "active_url" => "The :attribute is not a valid URL.",
    "after" => "The :attribute must be a date after :date.",
    "alpha" => "The :attribute may only contain letters.",
    "alpha_dash" => "The :attribute may only contain letters, numbers, and dashes.",
    "alpha_num" => "The :attribute may only contain letters and numbers.",
    "array" => "The :attribute must have selected elements.",
    "before" => "The :attribute must be a date before :date.",
    "between" => array(
        "numeric" => "The :attribute must be between :min - :max.",
        "file" => "The :attribute must be between :min - :max kilobytes.",
        "string" => "The :attribute must be between :min - :max characters.",
    ),
    "confirmed" => "The :attribute confirmation does not match.",
    "count" => "The :attribute must have exactly :count selected elements.",
    "countbetween" => "The :attribute must have between :min and :max selected elements.",
    "countmax" => "The :attribute must have less than :max selected elements.",
    "countmin" => "The :attribute must have at least :min selected elements.",
    "different" => "The :attribute and :other must be different.",
    "email" => "The :attribute format is invalid.",
    "exists" => "The selected :attribute is invalid.",
    "image" => "The :attribute must be an image.",
    "in" => "The selected :attribute is invalid.",
    "integer" => "The :attribute must be an integer.",
    "ip" => "The :attribute must be a valid IP address.",
    "match" => "The :attribute format is invalid.",
    "max" => array(
        "numeric" => "The :attribute must be less than :max.",
        "file" => "The :attribute must be less than :max kilobytes.",
        "string" => "The :attribute must be less than :max characters.",
    ),
    "mimes" => "The :attribute must be a file of type: :values.",
    "min" => array(
        "numeric" => "The :attribute must be at least :min.",
        "file" => "The :attribute must be at least :min kilobytes.",
        "string" => "The :attribute must be at least :min characters.",
    ),
    "not_in" => "The selected :attribute is invalid.",
    "numeric" => "The :attribute must be a number.",
    "required" => "The :attribute field is required.",
    "same" => "The :attribute and :other must match.",
    "size" => array(
        "numeric" => "The :attribute must be :size.",
        "file" => "The :attribute must be :size kilobyte.",
        "string" => "The :attribute must be :size characters.",
    ),
    "unique" => "The :attribute has already been taken.",
    "url" => "The :attribute format is invalid.",
    /*
      |--------------------------------------------------------------------------
      | Custom Validation Language Lines
      |--------------------------------------------------------------------------
      |
      | Here you may specify custom validation messages for attributes using the
      | convention "attribute_rule" to name the lines. This helps keep your
      | custom validation clean and tidy.
      |
      | So, say you want to use a custom validation message when validating that
      | the "email" attribute is unique. Just add "email_unique" to this array
      | with your custom message. The Validator will handle the rest!
      |
     */

    'custom' => array(
        'username_required' => 'Το email σας είναι απαραίτητο.',
        'username_email' => 'Το email δεν είναι έγκυρο.',
        'username_unique' => 'Ο χρήστης υπάρχει στο σύστημα.',
        'password_required' => 'Εισάγετε τον κωδικό πρόσβασης.',
        'password_min' => 'Ο κωδικός πρόσβασης πρέπει να είναι μεγαλύτερος απο 4 χαρακτήρες.',
        'password_confirmed' => 'Οι κωδικοί δεν ταιριάζουν.',
        'tel_size' => 'Τα ψηφία του τηλεφώνου δεν έιναι έγκυρα.',
        'tel_numeric' => 'Το τηλέφωνο δεν έιναι έγκυρο.',
        'mobile_size' => 'Τα ψηφία του κινητού τηλεφώνου δεν έιναι έγκυρα.',
        'mobile_numeric' => 'Το κινητό τηλέφωνο δεν έιναι έγκυρο.',
        'dog_name_required' => 'Συμπληρώστε το όνομα του σκύλου.',
        'dog_gender_not_in' => 'Συμπληρώστε το φύλο του σκύλου',
        'dog_postal_required' => 'Συμπληρώστε τον ταχυδρομικό κωδικό της περιοχής που χάθηκε ο σκύλος.',
        'dog_postal_size' => 'O ταχυδρομικός κωδικός δεν είναι έγκυρος. Λανθασμένος αριθμός ψηφίων.',
        'dog_postal_numeric' => 'O ταχυδρομικός κωδικός δεν είναι έγκυρος. Μόνο αριθμός επιτρέπεται.',
        'dog_date_required' => 'Συμπληρώστε την ημερομηνία.',
        'dog_date_before' => 'H ημερομηνία είναι λάνθασμένη.',
        'dog_image_max' => 'Το μέγεθος της φωτογραφίας δεν θα πρέπει να ξεπερνά τα 500ΚΒ.',
        'dog_image_mimes' => 'Ο τύπος της φωτογραφίας δεν υποστηρίζεται. PNG και JPEG μόνο.',
        'dog_name_alpha' => 'Το όνομα θα πρέπει να περιέχει μόνο γράμματα.',
        'first_name_alpha' => 'Το όνομα θα πρέπει να περιέχει μόνο γράμματα.',
        'last_name_alpha' => 'Το επίθετο θα πρέπει να περιέχει μόνο γράμματα.' 
    ),
    /*
      |--------------------------------------------------------------------------
      | Validation Attributes
      |--------------------------------------------------------------------------
      |
      | The following language lines are used to swap attribute place-holders
      | with something more reader friendly such as "E-Mail Address" instead
      | of "email". Your users will thank you.
      |
      | The Validator class will automatically search this array of lines it
      | is attempting to replace the :attribute place-holder in messages.
      | It's pretty slick. We think you'll like it.
      |
     */

    'attributes' => array(),
);