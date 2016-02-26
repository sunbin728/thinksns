<?php/** *  * @author jason * */require_once 'BaseApi.class.php';class UserApi extends BaseApi
{
    //获取用户信息    public function profile()
    {
        if (empty($this->data['uid'])) {
            return false;
        }
        $content = $this->getContentFormDiscuz('profile', '&uid='.$this->data['uid']);
        $content = $content['space'];        //dump($content);        $data['uid'] = $content['uid'];
        $data['username'] = $content['username'];
        $data['avatar_small'] = $this->discuzURl.'/uc_server/avatar.php?uid='. $content['uid'].'&size=small';
        $data['avatar_middle'] = $this->discuzURl.'/uc_server/avatar.php?uid='. $content['uid'].'&size=middle';
        $data['avatar_big'] = $this->discuzURl.'/uc_server/avatar.php?uid='. $content['uid'].'&size=big';
        $data['thread_count'] = $content['threads'];
        $data["following_count"] = $content['following'];
        $data["follower_count"] = $content['follower'];
        $data["feed_count"] = $content['feeds'];        //$data['sex'] = '';  //TODO 待补充        $data['user_group'] = array(0=>array(            'user_group_id'=>$content['groupid'],            'user_group_name'=>$content['group']['grouptitle'],            'user_group_icon'=>$content['group']['icon']        ));        //$data['medals'] = array(); //TODO 待补充        return $data;
    }    /**	 * 上传头像 API	 * 传入的头像变量 $_FILES['Filedata']	 */    public function upload_face()
    {/*		$dAvatar = model('Avatar');		$dAvatar->init($this->mid); // 初始化Model用户id		$res = $dAvatar->upload(true);		//Log::write(var_export($res,true));		if($res['status'] == 1){			$data['picurl'] = $res['data']['picurl'];			$data['picwidth'] = $res['data']['picwidth'];			$data['w'] = $res['data']['picwidth'];			$data['h'] = $res['data']['picheight'];			$data['x1'] = $data['y1'] = 0;			$data['x2'] = $data['w'];			$data['y2'] = $data['h'];			$r = $dAvatar->dosave($data);		}else{			return '0';		}*/
    }    /**	 *	关注一个用户	 */    public function follow_create()
    {
        if (empty($this->mid) || empty($this->user_id)) {
            return 0;

        }
        $r = uc_friend_add($this->mid, $this->user_id);
        return $r;

    }    /**	 * 取消关注	 */    public function follow_destroy()
    {
        if (empty($this->mid) || empty($this->user_id)) {
            return 0;

        }        
        $r = uc_friend_delete($this->mid, $this->user_id);
        return $r;

    }
    public function user_friend()
    {
        return $this->_follows(1);

    }/*	direction:     0:(默认值) 指定用户的全部好友	1:正向，指定用户添加的好友，但没被对方添加	2:反向，指定用户被哪些用户添加为好友，但没被对方添加	3:双向，互相添加为好友*/    public function _follows($direction)
    {
        $this->user_id = empty($this->user_id) ? $this->mid : $this->user_id;
        $page = $this->data['page'] ? $this->data['page'] : 1;
        $limit = $this->data['limit'] ? $this->data['limit'] : 20;
        $total = uc_friend_totalnum($this->user_id, $direction);
        $list = uc_friend_ls($this->user_id, $page, $limit, $total, $direction);
        return $list;

    }    //获取我收藏的帖子    public function myfavthread()
    {
        $page = $this->data['page'] ? $this->data['page']: 1;
        $content = $this->getContentFormDiscuz('myfavthread', '&page='.$page);
        return $content;
    }    //获取我收藏的版块    public function myfavforum()
    {
        $content = $this->getContentFormDiscuz('myfavforum');
        return $content;
    }    //获取我的帖子    public function mythread()
    {
        $page = $this->data['page'] ? $this->data['page'] : 1;
        $content = $this->getContentFormDiscuz('mythread', '&page='.$page);
        return $content;
    }    //获取我的私人消息    public function mypm()
    {
        $page = $this->data['page'] ? $this->data['page'] : 1;
        $content = $this->getContentFormDiscuz('mypm', '&page='.$page);
        return $content;
    }    //获取我的公共消息    public function publicpm()
    {
        $page = $this->data['page'] ? $this->data['page'] : 1;
        $content = $this->getContentFormDiscuz('publicpm', '&page='.$page);
        return $content;
    }    //加发消息人    public function friend()
    {
        $page = $this->data['page'] ? $this->data['page'] : 1;
        $limit = $this->data['limit'] ? $this->data['limit'] : 20;
        $uid = $this->data['uid'] ? $this->data['uid'] : $this->mid;
        $content = $this->getContentFormDiscuz('friend', '&page='.$page.'&limit='.$limit.'&uid='.$uid);
        return $content;
    }    //发消息操作    public function sendpm()
    {
        $touid = $this->data['touid'];
        $pmid = $this->data['pmid'];
        $opt = '&pmsubmit=yes&touid='.$touid.'&pmid='.$pmid;
        $content = $this->getContentFormDiscuz('sendpm', $opt, 'POST');
        return $content;
    }    //退出登录    public function logout()
    {        //TODO
    }    //登录    public function login()
    {        //TODO
    }

}
