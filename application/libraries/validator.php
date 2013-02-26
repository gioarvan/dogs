<?php

class Validator extends Laravel\Validator {

    const Greek = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZαβγδεζηθικλμνξοπρστυφχψωςΑΒΓΔΕΖΗΘΙΚΛΜΝΞΟΠΡΣΤΥΦΧΨΩάΆέΈόΌώΏίϊΐΊΪύϋΰΎΫήΉ ';

    public function validate_greek_english($attribute, $value, $parameters) {
        return (preg_match('/^[' . self::Greek . ']+$/', $value) != 0);
    }

    public function validate_greek_num($attribute, $value, $parameters) {
        return (preg_match('/^[0-9' . self::Greek . ']+$/', $value) != 0);
    }

    public function validate_greek_dash($attribute, $value, $parameters) {
        return (preg_match('/^[-_0-9' . self::Greek . ']+$/', $value) != 0);
    }

}
?>