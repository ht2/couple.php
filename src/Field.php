<?php namespace couple;

include_once(__DIR__ . '/Merge.php');
include_once(__DIR__ . '/Validate.php');

class Field extends Couple {

  protected $optional, $states, $extend, $def, $merge, $validate;

  public function __construct() {
    $this->optional = false;
    $this->states = [];
    $this->extend = [];
    $this->default = null;
    $this->merge = new Merge();
    $this->validate = new Validate();
  }

  public function run($haystack) {
    // Merges the `haystack` with the `default`.
    $mergedHaystack = $this->merge->run($haystack, $this->default);

    // Returns `true` if the haystack is not defined and it's optional.
    if (!$haystack) {
      return $this->optional;
    }

    // Tries to match the haystack with a state.
    else if (count($this->states) > 0) {
      foreach ($this->states as $state) {
        // Merges the state with `extend`
        $state = $this->merge->run($this->extend, $state);

        try {
          // Validates that the `mergedHaystack` matches the `state`.
          if (!$this->validate->run($state, $mergedHaystack)) {
            return false;
          }
        } catch (TypedCoupleException $e) {
          return false;
        }

        return true;
      }
    }

    // Tries to match the haystack with `extend` if no states are defined.
    else {
      return $this->validate->run($this->extend, $mergedValue);
    }
  }

  public function setExtend($extend) {
    // Merges the previous `extend` with the new one.
    $this->extend = $this->merge->run($extend, $this->extend);
    return $this;
  }

  public function addStates($states) {
    // Merges the previous `states` with the new ones.
    $this->extend = array_merge($this->states, $states);
    return $this;
  }

  public function setOptional($optional) {
    $this->optional = $optional;
    return $this;
  }

  public function setDefault($default) {
    // Merges the previous `default` with the new one.
    $this->default = $this->merge->run($default, $this->default);
    return $this;
  }
}
