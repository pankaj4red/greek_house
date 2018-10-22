<?php

namespace App\Console\Commands;

use App\Models\File;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;

class CacheImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gh:cache_images';

    /**
     * The console command description.
     */
    protected $description = 'Caches all the active images into storage/public/image';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $files = File::query()->where('name', 'like', '%.png')->orWhere('name', 'like', '%.jpg')->orWhere('name', 'like', '%.gif')->orderBy('id', 'desc')->get();
        $this->info('Count: '.$files->count());
        $count = 0;
        $removed = 0;
        $cached = 0;
        foreach ($files as $file) {
            $result = DB::select("select id from files where deleted_at is null and id = ? and id in (
                select file_id from artwork_files where file_id is not null and deleted_at is null
                union all
                select file_id from artwork_request_files where file_id is not null and deleted_at is null
                union all
                select file_id from campaign_files where file_id is not null and deleted_at is null
                union all
                select image1_id from campaign_leads where image1_id is not null and deleted_at is null
                union all
                select image2_id from campaign_leads where image2_id is not null and deleted_at is null
                union all
                select image3_id from campaign_leads where image3_id is not null and deleted_at is null
                union all
                select image4_id from campaign_leads where image4_id is not null and deleted_at is null
                union all
                select image5_id from campaign_leads where image5_id is not null and deleted_at is null
                union all
                select image6_id from campaign_leads where image6_id is not null and deleted_at is null
                union all
                select image7_id from campaign_leads where image7_id is not null and deleted_at is null
                union all
                select image8_id from campaign_leads where image8_id is not null and deleted_at is null
                union all
                select image9_id from campaign_leads where image9_id is not null and deleted_at is null
                union all
                select image10_id from campaign_leads where image10_id is not null and deleted_at is null
                union all
                select image11_id from campaign_leads where image11_id is not null and deleted_at is null
                union all
                select image12_id from campaign_leads where image12_id is not null and deleted_at is null
                union all
                select file_id from comments where file_id is not null and deleted_at is null
                union all
                select file_id from design_files where file_id is not null and deleted_at is null
                union all
                select thumbnail_id from designs where thumbnail_id is not null and deleted_at is null
                union all
                select image_id from garment_categories where image_id is not null and deleted_at is null
                union all
                select image_id from garment_genders where image_id is not null and deleted_at is null
                union all
                select thumbnail_id from product_colors where thumbnail_id is not null and deleted_at is null
                union all
                select image_id from product_colors where image_id is not null and deleted_at is null
                union all
                select image_id from products where image_id is not null and deleted_at is null
                union all
                select avatar_id from users where avatar_id is not null and deleted_at is null
                union all
                select avatar_thumbnail_id from users where avatar_thumbnail_id is not null and deleted_at is null
                ) order by id desc", [$file->id]);
            if (count($result) == 0) {
                // need removing
                DB::table('files')->where('id', $file->id)->update([
                    'deleted_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $removed++;
                $this->output->write('-');
            } else {
                $this->output->write('.');
                $cached++;
                $file->cacheContent();
            }
            if (++$count % 100 == 0) {
                $this->output->write($count);
            }
        }

        $this->info('Count: '.$files->count());
        $this->info('Cached: '.$cached);
        $this->info('Removed: '.$removed);

        return;
    }
}
