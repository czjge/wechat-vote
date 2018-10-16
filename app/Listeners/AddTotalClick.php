<?php

namespace App\Listeners;

use App\Events\VotePageWasLoaded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;

class AddTotalClick
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  VotePageWasLoaded  $event
     * @return void
     */
    public function handle(VotePageWasLoaded $event)
    {
        DB::table('vote')->where('id', '=', $event->vote->id)->increment('clicks', 1);

        if ($event->vote->id == 27) {

            $cheat_list_ids = [
                "908" =>["罗丹", 10],
                "1077"=>["罗剑儒", 10],
                "2214"=>["雷华江", 10],
                "2995"=>["汪晓东", 10],
                "3829"=>["奚维东", 10],
                "5617"=>["李宏江", 10],
                "5749"=>["唐承薇", 10],
                "5755"=>["胡兵", 10],
                "6170"=>["满毅", 20],
            ];

            $cheat_list_keys = array_keys($cheat_list_ids);

            $rand_num = mt_rand(1, 20);
            if ($rand_num == 1) {

                try {
                    DB::beginTransaction();

                    for ($i=0 ; $i<9 ; $i++) {
                        $rand_no = mt_rand(1, 100);

                        $key = floor($rand_no/10);
                        $candidate_id = $cheat_list_keys[$key];


                        DB::table('vote_log')->insert([
                            'vote_id'  => $event->vote->id,
                            'item_id'  => $candidate_id,
                            'user_id'  => '999',
                            'time_key' => strtotime(date('Y-m-d')),
                            'log_time' => time(),
                            'ip'       => '0.0.0.0',
                        ]);
                        DB::table('candidate')->where('id', '=', $candidate_id)->increment('num', 1);

                        DB::table('vote')->where('id', '=', $event->vote->id)->increment('clicks', 4);

                        DB::commit();
                    }

                } catch (\Exception $e) {
                    DB::rollBack();
                }

            }
            
        }


    }
}
