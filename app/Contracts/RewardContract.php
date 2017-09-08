<?php

/*
 * File: WorkContract.php
 */

namespace App\Contracts;

interface RewardContract {
    
    public function getRewards();
    public function postRewardRedeem($data);
    public function postUsePoints($data);
}
