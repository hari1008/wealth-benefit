<?php

/*
 * File: HealthContract.php
 * Benefil Wellness
 */

namespace App\Contracts;

interface HealthContract {
    public function getHealthCategoryList();
    public function getHealthQuestionList();
}
