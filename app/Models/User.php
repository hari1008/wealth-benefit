<?php

/*
 * File: User.php
 */

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Codes\Constant;
use App\Helper\Utility\CommonHelper;
use App\Models\Goal;
use Illuminate\Support\Facades\Config;
use App\Models\Setting;


class User extends Authenticatable
{
    use SoftDeletes;
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'facebook_id', 'email', 'is_verified',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'updated_at', 'deleted_at'
    ];
   
    protected $appends = [];
    
    protected $casts = [
        'user_id' => 'integer',
        'gender' => 'integer',
        'activation_type' => 'integer',
        'user_type' => 'integer',
        'current_health_device_id' => 'integer',
        'language' => 'integer',
        'vitality_age' => 'integer',
        'is_interested_for_expert' => 'integer',
        'forget_password_count' => 'integer',
        'is_password_changed' => 'integer',
        'is_verified' => 'integer',
        'is_blocked' => 'integer',
        'is_profile_completed'=>'integer',
        'working_location_lat'=>'double',
        'working_location_long'=>'double'
        
        
    ];     
    
    public function calendar()
    {
        return $this->hasMany('App\Models\ExpertCalendar', 'expert_id', 'user_id');
    }
    
    public function expertBooking()
    {
        return $this->hasMany('App\Models\UserBooking', 'expert_id', 'user_id');
    }
    
    public function categories()
    {
        return $this->hasMany('App\Models\ExpertHealthCategories', 'expert_id', 'user_id');
    }
    public function qualifications()
    {
        return $this->hasMany('App\Models\ExpertQualification', 'expert_id', 'user_id');
    }
    public function ecosystem()
    {
        return $this->hasOne('App\Models\MasterEcosystem', 'ecosystem_id', 'ecosystem_id');
    }
    
    public function subAdminEcosystem()
    {
        return $this->hasOne('App\Models\MasterEcosystem', 'subadmin_user_id', 'user_id');
    }
    
    public function works()
    {
        return $this->hasOne('App\Models\MasterWorks', 'work_id', 'work_id');
    }
    public function SessionPrices()
    {
        return $this->hasOne('App\Models\SessionPrice', 'expert_id', 'user_id');
    }
    public function inviteReceiver()
    {
        $instance = $this->hasOne('App\Models\UserInvite', 'invited_user_id', 'user_id');
        $instance->getQuery()->where('user_id',Auth::user()->user_id);
        $instance->getQuery()->where('is_withdrawn', Constant::$INVITE_WITHDRAW_NO);
        return $instance;
    }
    
    
    public function purchasedSessions()
    {
        $instance = $this->hasOne('App\Models\UserSession', 'expert_id', 'user_id');
        $instance->getQuery()->where('user_id',Auth::user()->user_id);
        return $instance;
    }
    
    
    public function currentWeekGoal()
    {
        $instance = $this->hasOne('App\Models\Goal', 'user_id', 'user_id')->select(['goal_achieved','user_id']);
        $now = new \DateTime('now');
        $currentDate = $now->format('Y-m-d');
        $weekNumber = CommonHelper::getWeekNumber($currentDate); 
        $instance->getQuery()->where('week_number',$weekNumber);
        return $instance;
    }
    
    public function allWeeklyGoals()
    {
        $instance = $this->hasMany('App\Models\Goal', 'user_id', 'user_id')->select([DB::raw('count("is_weekly_goals_achieved") as weekly_goals')])->where('is_weekly_goals_achieved', Constant::$YES);
        return $instance;
    }
    
    public function allRedeemedRewards()
    {
        $instance = $this->belongsToMany('App\Models\MasterReward','user_rewards')->select([DB::raw('count(*) as redeemed_rewards')]);
        return $instance;
    }
    
    public function allWalletRewards()
    {
        $instance = $this->hasMany('App\Models\UserWallet', 'user_id', 'user_id')->select([DB::raw('count(*) as wallet_rewards')]);
        return $instance;
    }
    
    public function healthScore()
    {
        $instance = $this->hasOne('App\Models\Goal', 'user_id', 'user_id')->selectRaw('CAST(sum(health_score) as UNSIGNED) as health_score,user_id');
        $now = new \DateTime('now');
        $year = $now->format('Y');
        $instance->getQuery()->whereYear('date',$year)->groupBy('user_id');
        return $instance;
    }
    
    public function expertcalendar()
    {
        return $this->hasMany('App\Models\ExpertCalendar', 'expert_id', 'user_id');
    }
    
    /**
        * 
        * Does creation of User
        * 
        * @param $json which contains information of User that we need to save 
        * 
        * @return Created User Object
        * 
    */    
    public static function createUser($json){
        $allExistingBarCodes = array_unique(User::pluck('unique_bar_code')->toArray());
        $barCode = CommonHelper::getRandSecure(Constant::$USER_BAR_CODE_LENGTH,$allExistingBarCodes, Constant::$NUMERIC);
        $userModel = new User();
        $userModel->email = CommonHelper::scriptStripper($json['email']);
        $userModel->password = Hash::make($json['password']);
        $userModel->facebook_id = '';
        $userModel->user_type = Constant::$PLUS_USER;
        $userModel->activation_type = '';
        $userModel->email_verify_token = CommonHelper::getUniqueToken();
        $userModel->unique_bar_code = $barCode;
        $userModel->activation_code = $json['activationCode'];
        $userModel->ecosystem_id = $json['ecosystemId'];
        $userModel->latitude = Constant::$NULLLATLONG;
        $userModel->longitude = Constant::$NULLLATLONG;
        $userModel->save();
        $userModel = User::where('email',$json['email'])->with('ecosystem.features')->first();
        return $userModel;
    }
    
    
    /**
        * 
        * Find User by their Id
        * 
        * @param $userid which contains id of User 
        * 
        * @return User Object
        * 
    */  
    public static function getUserById($userid){
        return User::where('user_id',$userid)->first();
    }
    
    /**
        * 
        * Find User by their Mail and Password
        * 
        * @param $json which contains Mail and Password of User 
        * 
        * @return User Object
        * 
    */
    public static function getUserByMailAndPassword($json)
    {
         if(Auth::attempt(['email' => $json['email'], 'password' => $json['password']])) 
         {
            return User::where('email', $json['email'])->with('ecosystem.features')->first();
         }
         else
         {
             return false;
         }
    }
    
    /**
        * 
        * Find User by their Mail 
        * 
        * @param $json which contains Mail of User 
        * 
        * @return User Object
        * 
    */
    public static function getUserByMail($email){
         return User::where('email', $email)->with('ecosystem.features')->first();
    }
    
    /**
        * 
        * Find User by facebook id and create if not found
        * 
        * @param $json which contains data of User 
        * 
        * @return User Object
        * 
    */
    public static function getUserByFacebookId($json){
        
        $user = User::where('facebook_id', $json['facebookId'])->first();
        if (is_object($user)){ 
            $user->email = $json['email']; 
            $user->password = Hash::make($json['password']);
        }
        else{
            $user = User::where('email', $json['email'])->first();
            if (is_object($user)){ 
                $user->facebook_id = $json['facebookId']; 
                $user->password = Hash::make($json['password']);
            }
            else
            {
                $user = new User();
                $user->email = $json['email'];
                $user->facebook_id = $json['facebookId'];
                $user->password = Hash::make($json['password']);
            }
        }
        $user->wrong_signin_count = NULL; 
        $user->wrong_signin_count = 0;   
        $user->forget_password_count = 0;
        $user->save();
        return $user;
    }
    
    /**
        * 
        * Searching for Experts
        * 
        * @param $data which contains information about filters that need to be applied 
        * 
        * @return list of the Experts
        * 
        * @functionality    - Searching Health Professional on the basis of health categories if expertType = 2
        *                   - Searching Personal Traier on the basis of Gym Name if expertType = 1 
        *                   - Calculating their distance from user as well as their average rating
        *                   - Sorting on the Behalf of Distance and Average Rating
        * 
    */
    
    public static function searchExpert($data){
        
        if($data->input('expertType') == Constant::$HEALTH_PROFESSIONAL){
            $health_cat_id = explode(',',$data->input('expertCategory'));
        }
        $lat = $data->input('workingLocationLat');
        $lon = $data->input('workingLocationLong');
        
        $query = User::select(DB::raw("users.*,IFNULL(( 6371* acos( cos( radians($lat) ) * cos( radians( working_location_lat ) )* cos( radians( working_location_long ) "
                        . "- radians($lon)) + sin( radians($lat) ) *sin( radians( working_location_lat ) ) )),0) AS distance ,avg(rating) as avgRatings"
                        ))
                        ->leftjoin('user_feedback','user_feedback.expert_id','=','users.user_id')
                        ->having('distance','<=', Constant::$EXPERT_SEARCH_RADIUS);
        if($data->input('expertType') == Constant::$HEALTH_PROFESSIONAL){
            $query->whereHas('categories',function($query) use ($health_cat_id){
                                                $query->whereIn('category_id',$health_cat_id);
                                  });
            $query->with(['categories']);
        }
        
        $query->where('expert_type',$data->input('expertType'));
        $query->where('is_interested_for_expert',Constant::$EXPERT_CONFIRM);
        $query->where('is_verified',Constant::$Verified);
        $query->where('is_blocked',Constant::$NotBlocked);
        $query->where('users.user_id','!=',Auth::user()->user_id);
        
        if(!empty($data->input('gender'))){
            $query->whereIn('gender',explode(',',$data->input('gender')));
        }
        if($data->input('expertType') == Constant::$PERSONAL_TRAINER){
            $query->whereIn('work_id', explode(',',$data->input('workId')));
            $query->with('SessionPrices');
            $query->with('purchasedSessions');
            $minPrice = $data->input('minPriceValue');
            $maxPrice = $data->input('maxPriceValue');
            $query->whereHas('SessionPrices',function($query) use ($minPrice,$maxPrice) {
                                                $query->whereBetween('one_session',array($minPrice,$maxPrice));
                                  });
        }
        $query->with('works','qualifications');
        $query->groupBy('users.user_id');
        if($data->input('sortBy') == Constant::$SORT_BY_DISTANCE) {
            $query->orderBy('distance','asc');
        } 
        elseif($data->input('sortBy') == Constant::$SORT_BY_RATING){
            $query->orderBy('avgRatings','desc');
        } 
        return $query;
    }
    
    /**
        * 
        * Find Expert Profile
        * 
        * @param $expert_id contains id of Expert(User) 
        * 
        * @return User Object
        * 
    */
    public static function expertProfile($expert_id){
        $now = new \DateTime('now');
        $year = $now->format('Y'); 
        $expertInfo = User::where('user_id',$expert_id)
//                         ->where('user_type',Constant::$EXPERT_USER)
                         ->with(['categories','qualifications','SessionPrices','currentWeekGoal'])
                         ->first();
        $expertInfo['healthScore'] = Goal::getHealthScore(Auth::user()->user_id, $year);
        return $expertInfo;
    }
    
    /**
        * 
        * Find Expert Profile
        * 
        * @param $expert_id contains id of Expert(User) 
        * 
        * @return User Object
        * 
    */
    public static function updateExpertProfile($data){
       $expertProfile = Auth::user();
       if(!empty($data->input('address'))){
           $expertProfile->address = $data['address'];
       } 
       if(!empty($data->input('workId'))){
            $expertProfile->work_id = $data['workId'];
       }
       if(!empty($data->input('workName'))){
            $expertProfile->work_name = CommonHelper::scriptStripper($data['workName']);
       }
       if(!empty($data->input('countryCode'))){
           $expertProfile->countryCode = CommonHelper::scriptStripper($data['countryCode']);
       }
       $expertProfile->first_name = CommonHelper::scriptStripper($data['firstName']);
       $expertProfile->last_name = CommonHelper::scriptStripper($data['lastName']);
       $expertProfile->city = CommonHelper::scriptStripper(isset($data['city']) ? $data['city'] : '');
       $expertProfile->residence_country = CommonHelper::scriptStripper(isset($data['residenceCountry']) ? $data['residenceCountry'] : '');
       $expertProfile->gender = $data['gender'];
       $expertProfile->dob = $data['dob'];
       $expertProfile->mobile = CommonHelper::scriptStripper($data['mobile']);
       $expertProfile->expert_type = $data['expertType'];
       if($expertProfile['is_interested_for_expert'] != Constant::$EXPERT_CONFIRM){
           $expertProfile->is_interested_for_expert = Constant::$INTERESTED;
       }
       $expertProfile->working_speciality = $data['workingSpeciality'];
       $expertProfile->working_location = CommonHelper::scriptStripper($data['workingLocation']); 
       $expertProfile->working_location_lat = $data['workingLocationLat'];  
       $expertProfile->working_location_long = $data['workingLocationLong'];  
       $expertProfile->expert_contact_number = $data['expertContactNumber'];
       $expertProfile->website = CommonHelper::scriptStripper($data['website']);
//       $expertProfile->user_type = Constant::$EXPERT_USER; // toberemoved
      
       $result = $expertProfile->save();
        
       if($result){
            return $expertProfile;
        }
        else{
            return $result;
        }
    }
    
    
    
    /**
        * 
        * Updating Activation code with respect to the logged in User
        * 
        * @param $json contains User Type and Activation Code
        * 
        * @return User Object on success , false otherwise
        * 
    */
    public static function updateActivationCode($json){
        $userModel = Auth::user();   
        $userModel->activation_code = CommonHelper::scriptStripper($json['activationCode']);
        $userModel->user_type = $json['userType'];
        $userModel->ecosystem_id = $json['ecosystemId'];
        $result = $userModel->save();
        if($result){
            return User::where('email', $userModel['email'])->with('ecosystem.features')->first();
        }
        else{
            return $result;
        }
        
    }
    
    /**
        * 
        * Updating Users Profile
        * 
        * @param $json contains information of User
        * 
        * @return Updatedc User Object on success , false otherwise
        * 
    */
    public static function updateUser($json){
        $userModel = Auth::user();
        $userModel->first_name = CommonHelper::scriptStripper($json['firstName']);
        $userModel->last_name = CommonHelper::scriptStripper($json['lastName']);
        $userModel->countryCode = CommonHelper::scriptStripper($json['countryCode']);
        $userModel->mobile = CommonHelper::scriptStripper($json['mobile']);
        $userModel->nationality = CommonHelper::scriptStripper(isset($json['nationality']) ? $json['nationality'] : '');
        $userModel->city = CommonHelper::scriptStripper(isset($json['city']) ? $json['city'] : '');
        $userModel->residence_country = CommonHelper::scriptStripper(isset($json['residenceCountry']) ? $json['residenceCountry'] : '');
        $userModel->gender = $json['gender'];
        $userModel->dob = $json['dob'];
        if(!empty($json['language'])){
            $userModel->language = CommonHelper::scriptStripper($json['language']);
        }
        if(!empty($json['language'])){
            $userModel->latitude = $json['latitude'];
        }
        if(!empty($json['language'])){
            $userModel->longitude = $json['longitude'];
        }
        if(!empty($json['userType'])){
            $userModel->user_type = $json['userType'];
        }
        if(!empty($json['image'])){
            $userModel->image = $json['image'];
        }
        
        $result = $userModel->save();
       
        if($result){
            $userModel->is_profile_completed = 1;
            $userModel->save();
            return $userModel;
        }
        else {
            return $result;
        }
    }
    
    /**
        * 
        * Updating User Password
        * 
        * @param $json contains information of User
        * 
        * @return Updatedc User Object on success , false otherwise
        * 
    */
    public static function updatePassword($userId, $tempPassword, $forcePasswordChange = 0){
        $user = User::find($userId);
        $user->password = Hash::make($tempPassword);
        $user->is_password_changed = $forcePasswordChange;
        $user->save();
        
    }
    
    /**
        * 
        * Updating wellness age with wellness age answers against User 
        * 
        * @param $age contains wellness age,$answers contains wellness age answers
        * 
        * @return Updated User Object on success , false otherwise
        * 
    */
    public static function updateWellnessAnswer($answers,$age,$user){
        $user->wellness_age_answers = CommonHelper::scriptStripper($answers);
        $user->vitality_age = $age;
        $result = $user->save();
        if($result){
            return $user;
        }
        else {
            return $result;
        }
    }
    public static function  deleteUser($ids=array()){
         $time = date('Y-m-d H:i:s');
         return User::whereIn('user_id',$ids)->update(array('deleted_at'=>$time));
        
    }
    public static function disapproveUserAsExpert($id){
        $affectedRows =  User::where('user_id',$id)->update(array('is_interested_for_expert'=>Constant::$EXPERT_REJECT,'expert_type'=>Constant::$NON_EXPERT));
        if($affectedRows){
            return self::getUserById($id);
        }
        return array();
    }
    public static function approveUserAsExpert($id){
        $affectedRows =  User::where('user_id',$id)->update(array('is_interested_for_expert'=>Constant::$EXPERT_CONFIRM));
        if($affectedRows){
            return self::getUserById($id);
        }
        return array();
    }
    
    public static function getRegisterUsersEmail($usersNeedToInviteEmails){
        $registeredUsersEmail = User::select('email')->whereIn('email',$usersNeedToInviteEmails)->pluck('email')->toArray(); 
        return $registeredUsersEmail;
    }
    
    public static function getRegisterUsersId($usersNeedToInviteEmails){
        $registeredUsersId = User::select('user_id')->whereIn('email',$usersNeedToInviteEmails)->pluck('user_id')->toArray();
        return $registeredUsersId;
    }
    
    /**
        * 
        * Update current lat long of User
        * 
        * @param $lat,$long contains latitude and longitude of User
        * 
        * @return Null
        * 
    */
    public static function updateUserLatLong($lat,$long){
       $loggedUserProfile = Auth::user();
       $loggedUserProfile->latitude = $lat;
       $loggedUserProfile->longitude = $long;
       $loggedUserProfile->save();
    }
    
    /**
        * 
        * Find User by facebook id and create if not found
        * 
        * @param $json which contains data of User 
        * 
        * @return User Object
        * 
    */
    public static function createUserByFacebookId($json){

        $user = User::firstOrNew(['email' => $json['email']]);
        $user->facebook_id = $json['facebookId'];
        $user->is_verified = Constant::$Verified;
        $user->save();
        $user = User::where('email', $json['email'])->with('ecosystem.features')->first();
        return $user;
    }
    
    /**
        * 
        * Provide User profile with its goal details
        * 
        * @param NULL
        * 
        * @return User Object
        * 
    */
    public static function getUserProfileWithGoals(){
        $user = Auth::user();
        $now = new \DateTime('now');
        $year = $now->format('Y');
        $currentDate = $now->format('Y-m-d');
        $weekNumber = CommonHelper::getWeekNumber($currentDate); 
        if(!empty(Auth::user()->tier_start_week) && !empty(Auth::user()->tier_start_year)){
            
            // getting first and last dates of tier week period
            $tierDates = CommonHelper::getFirstAndLastDateOfWeek(Auth::user()->tier_start_week,Auth::user()->tier_start_year,Constant::$TOTAL_NUMBER_WEEK_FOR_CALCULATION);
            
            // getting number of weekly goals acheived  in tier week period
            $totalNumberOfGoals = Goal::getWeeklyGoalAcheivedCount(Auth::user()->user_id,$tierDates['startDate'], $tierDates['endDate']);
            
            // upgrade tier if last week ends or goals achived
            if(($tierDates['endDate'] < $currentDate) || ($totalNumberOfGoals >= Constant::$WEEKLY_GOALS_FOR_UPGRADE)){
                self::tierUpgrade($user, $totalNumberOfGoals, $weekNumber, $year);
                $totalNumberOfGoals = 0;
            }
            
            $user['goalsAchieved'] = $totalNumberOfGoals;
            $user['goalsForNextLevel'] = Constant::$WEEKLY_GOALS_FOR_UPGRADE - $totalNumberOfGoals;
            $user['weeksRemaining'] = Constant::$TOTAL_NUMBER_WEEK_FOR_CALCULATION - CommonHelper::countTimeDIffrenceInWeeks($tierDates['startDate']);
        }
        else{
            User::updateUserTierInfoAndPoint($user,$weekNumber,$year);    
            $user['goalsAchieved'] = 0;
            $user['goalsForNextLevel'] = Constant::$WEEKLY_GOALS_FOR_UPGRADE;
            $user['weeksRemaining'] = Constant::$TOTAL_NUMBER_WEEK_FOR_CALCULATION;
        }
        $user['totalWeeks'] = Constant::$TOTAL_NUMBER_WEEK_FOR_CALCULATION;
        $user['healthScore'] = Goal::getHealthScore(Auth::user()->user_id, $year);
        $user['totalPoints'] = Auth::user()->reward_point;
        $user['rewardsUnlocked'] = EcosystemReward::getUnlockRewardsCount(Auth::user()->ecosystem_id,Auth::user()->current_tier);
        return $user;
    }
    
    /**
        * 
        * Update tier Information
        * 
        * @param NULL
        * 
        * @return User Object
        * 
    */
    public static function tierUpgrade($user,$goals,$weekNumber,$year){
        $currentTier = $user['current_tier'];
        $upgradeTier = Constant::$BLUE;
        if($goals >= Constant::$WEEKLY_GOALS_FOR_UPGRADE){
            if($currentTier == Constant::$GOLD){
                $upgradeTier = $currentTier;
            }
            else{
                $upgradeTier = ++$currentTier;
            }
            
        }
        else if($goals >= Constant::$WEEKLY_GOALS_FOR_RENEWAL && $goals < Constant::$WEEKLY_GOALS_FOR_UPGRADE){
            $upgradeTier = $currentTier;
        }
        else{
            if($currentTier != Constant::$BLUE){
               $upgradeTier = --$currentTier; 
            }
        }
        $user->current_tier = $upgradeTier;
        $user->tier_start_week = $weekNumber;
        $user->tier_start_year = $year;
        $user->save();
    }
    
    /**
        * 
        * Provide User profile with its goal details
        * 
        * @param NULL
        * 
        * @return User Object
        * 
    */
    public static function getUserProfileWithAvailability($user){
        $user['Qualifications'] = ExpertQualification::getExpertQualifications($user['user_id']);
        $user['SessionPrice'] = SessionPrice::getSessionPrice($user['user_id']);
        $user['ExpertCalendar'] = ExpertCalendar::getAllExpertCalendarRecord($user['user_id']);
        $introductoryData = Setting::getData(Config::get('constants.setting.introductory'));
        $user['defaultIntroductryPrice'] = !empty($introductoryData) ? (int)$introductoryData['description'] : '';
        return $user;
    }
    
    public static function getUserWithGoals($user){
        $now = new \DateTime('now');
        $year = $now->format('Y');
        $user['currentWeekGoal'] = $user->currentWeekGoal()->first();
        $user['healthScore'] = Goal::getHealthScore($user['user_id'], $year);
        return $user;
    }
    
    /**
        * 
        * Updating user tier week and rewards point information
        * 
        * @param $point         : points that need to update
        *        $userId        : Id of the user regarding whom we need to updated point and week Info
        *        $tierStartWeek : Start week of Tier wise  goal Period
        *        $tierStartYear : Start year of Tier wise  goal Period 
        * 
        * @return NULL
        * 
    */
    public static function updateUserTierInfoAndPoint($user,$tierStartWeek,$tierStartYear,$point=0){
       if(empty($user['tier_start_week'])){
           $user->tier_start_week = $tierStartWeek;
       }
       if(empty($user['tier_start_year'])){
           $user->tier_start_year = $tierStartYear;
       }
       $user->reward_point = $point;
       $user->save();
    }
    
    
    /**
        * 
        * Updating Single Field of User Profile
        * 
        * @param $json contains information of User
        * 
        * @return Updatedc User Object on success , false otherwise
        * 
    */
    public static function updateUserSpecificFileds($fieldsArray,$userId){
        if(!empty($fieldsArray)){
            $userProfile = User::findOrFail($userId);
            foreach($fieldsArray as $field=>$value){
                $userProfile->$field = $value;
            }
            $userProfile->save();
        }
    }
    
    /**
        * 
        * Updating Single Field of User Profile
        * 
        * @param $json contains information of User
        * 
        * @return Updatedc User Object on success , false otherwise
        * 
    */
    public static function updateSpecificFileds($fieldsArray,$userProfile){
        if(!empty($fieldsArray)){
            foreach($fieldsArray as $field=>$value){
                $userProfile->$field = $value;
            }
            $userProfile->save();
        }
    }
    
    
    public static function searchUser($data){
        $name = $data['name'];
        $users = User::where('is_verified',Constant::$Verified)
                ->where('is_blocked',Constant::$NotBlocked)
                ->where('first_name','!=','')
                ->where('user_id','!=',Auth::user()->user_id)
                ->where(function($q) use ($name) {
                    $q->whereRaw("concat(`first_name`,' ',`last_name`) LIKE '%". $name ."%'")
                      ->orWhere('email','like', '%'.$name.'%');
                })
                ->with('inviteReceiver')
                ->get();
        return $users;
    }
    
    
    public static function createSubAdmin($email,$password){
        $userModel = new User();
        $userModel->is_verified = Constant::$Verified;
        $userModel->email = CommonHelper::scriptStripper($email);
        $userModel->password = Hash::make($password);
        $userModel->user_type = Constant::$SUB_ADMIN;
        $userModel->email_verify_token = CommonHelper::getUniqueToken();
        $userModel->save();
        return $userModel;
    }
    
    public static function deleteExpert($user){
        $user->calendar()->forceDelete();
        $user->expertBooking()->forceDelete();
        $user->qualifications()->forceDelete();
        $user->categories()->forceDelete();
        $user->SessionPrices()->forceDelete();
        $user->bio = NULL;
        $user->work_id = NULL;
        $user->work_name = NULL;
        $user->working_location = NULL;
        $user->working_speciality = NULL;
        $user->expert_contact_number = NULL;
        $user->expert_type = Constant::$NON_EXPERT;
        $user->working_location_lat = Constant::$NULLLATLONG;
        $user->working_location_long = Constant::$NULLLATLONG;
        $user->is_interested_for_expert = Constant::$NOT_INTERESTED;
        $user->save();
        return $user;
    }
}
