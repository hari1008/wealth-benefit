<?php

/*
 * File: WalletContract.php
 */

namespace App\Contracts;

interface WalletContract {
    public function getWalletRewardList();
    public function postAddRewardInWallet($request);
}
