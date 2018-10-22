<?php

namespace App\Console\Commands;

use App\Console\ConsoleOutput;
use App\Models\Campaign;
use App\Models\Chapter;
use App\Models\Design;
use App\Models\DesignTag;
use App\Models\School;
use App\Models\User;
use DB;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class IntegrityCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gh:integrity_check {--fix}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Performs an integrity check to the website data.';

    /**
     * Try to fix any errors found
     *
     * @var bool
     */
    protected $fix = false;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->option('fix')) {
            $this->fix = true;
        }

        ConsoleOutput::setConsoleOutput($this->output);

        $this->checkUsers();
        $this->checkCampaigns();
        $this->checkDesigns();
        $this->checkChapter();
        $this->checkSchool();

        return;
    }

    /**
     * Checks users
     */
    public function checkUsers()
    {
        $this->checkUserCritical();
        $this->checkUserPhone();
    }

    /**
     * Checks campaigns
     */
    public function checkCampaigns()
    {
        $this->checkCampaignDesigns();
        $this->checkCampaignPlaceholder();
        $this->checkCampaignNoUser();
        $this->checkCampaignNoArtworkRequest();
        $this->checkCampaignNoDesigner();
        $this->checkCampaignNoDecorator();
    }

    /**
     * Checks designs
     */
    public function checkDesigns()
    {
        $this->checkDesignInformation();
        $this->checkDesignNoTags();
        $this->checkDesignNoImages();
        $this->checkDesignTagTrim();
    }

    /**
     * Checks chapters
     */
    public function checkChapter()
    {
        $this->checkChapterTrim();
    }

    /**
     * Checks schools
     */
    public function checkSchool()
    {
        $this->checkSchoolTrim();
    }

    /**
     * Checks users without names or emails
     */
    public function checkUserCritical()
    {
        $users = User::query()->whereNull('first_name')->orWhere('first_name', '')->orWhereNull('last_name')->orWhere('last_name', '')->orWhereNull('email')->orWhere('email', '')->get();
        if ($users->count() > 0) {
            ConsoleOutput::title('[Users] No name or email ('.$users->count().')');
            foreach ($users as $user) {
                ConsoleOutput::info($user->id.' ');
            }
            ConsoleOutput::newLine();
        }
    }

    /**
     * Checks users without phone
     */
    public function checkUserPhone()
    {
        $users = User::query()->whereNull('phone')->orWhere('phone', '')->get();
        if ($users->count() > 0) {
            ConsoleOutput::title('[Users] No phone ('.$users->count().')');
            foreach ($users as $user) {
                ConsoleOutput::info($user->id.' ');
            }
            ConsoleOutput::newLine();
        }
    }

    /**
     * Checks campaigns without associated designs (design gallery)
     */
    public function checkCampaignDesigns()
    {
        $campaigns = Campaign::query()->whereDoesntHave('designs')->get();
        if ($campaigns->count() > 0) {
            ConsoleOutput::title('[Campaign] No designs ('.$campaigns->count().')');
            if ($this->fix) {
                ConsoleOutput::info('Fixing');
                foreach ($campaigns as $campaign) {
                    design_repository()->createFromCampaign($campaign);
                    ConsoleOutput::info('.');
                }
                ConsoleOutput::newLine();
            }

            foreach ($campaigns as $campaign) {
                ConsoleOutput::info($campaign->id.' ');
            }
            ConsoleOutput::newLine();
        }
    }

    /**
     * Checks campaigns without owners
     */
    public function checkCampaignNoUser()
    {
        $campaigns = Campaign::query()->whereDoesntHave('user')->get();
        if ($campaigns->count() > 0) {
            ConsoleOutput::title('[Campaign] No User ('.$campaigns->count().')');
            foreach ($campaigns as $campaign) {
                ConsoleOutput::info($campaign->id.' ');
            }
            ConsoleOutput::newLine();
        }
    }

    /**
     * Checks campaigns without artwork
     */
    public function checkCampaignNoArtworkRequest()
    {
        $campaigns = Campaign::query()->whereDoesntHave('artwork_request')->get();
        if ($campaigns->count() > 0) {
            ConsoleOutput::title('[Campaign] No ArtworkRequest ('.$campaigns->count().')');
            foreach ($campaigns as $campaign) {
                ConsoleOutput::info($campaign->id.' ');
            }
            ConsoleOutput::newLine();
        }
    }

    /**
     * Checks campaigns ahead of awaiting_design without a designer
     */
    public function checkCampaignNoDesigner()
    {
        $campaigns = Campaign::query()->whereHas('artwork_request', function ($query) {
            /** @var Builder $query */
            $query->whereDoesntHave('designer');
        })->whereIn('state', [
            'awaiting_approval',
            'revision_requested',
            'awaiting_quote',
            'collecting_payment',
            'processing_payment',
            'fulfillment_ready',
            'fulfillment_validation',
            'printing',
            'shipped',
            'delivered',
        ])->get();
        if ($campaigns->count() > 0) {
            ConsoleOutput::title('[Campaign] No Designer ('.$campaigns->count().')');
            foreach ($campaigns as $campaign) {
                ConsoleOutput::info($campaign->id.' ');
            }
            ConsoleOutput::newLine();
        }
    }

    /**
     * Checks campaigns ahead of fulfillment_ready without a decorator (printer)
     */
    public function checkCampaignNoDecorator()
    {
        $campaigns = Campaign::query()->whereDoesntHave('decorator')->whereIn('state', [
            'fulfillment_validation',
            'printing',
            'shipped',
            'delivered',
        ])->get();
        if ($campaigns->count() > 0) {
            ConsoleOutput::title('[Campaign] No Decorator ('.$campaigns->count().')');
            foreach ($campaigns as $campaign) {
                ConsoleOutput::info($campaign->id.' ');
            }
            ConsoleOutput::newLine();
        }
    }

    /**
     *Checks campaigns with the old user type (placeholder)
     */
    public function checkCampaignPlaceholder()
    {
        $campaigns = Campaign::query()->whereHas('user', function ($query) {
            /** @var Builder $query */
            $query->where('type_code', 'placeholder');
        })->get();
        if ($campaigns->count() > 0) {
            ConsoleOutput::title('[Campaign] Placeholder ('.$campaigns->count().')');
            foreach ($campaigns as $campaign) {
                ConsoleOutput::info($campaign->id.' ');
            }
            ConsoleOutput::newLine();
        }
    }

    /**
     * Checks uncompleted designs (design gallery)
     */
    public function checkDesignInformation()
    {
        $designs = Design::query()->whereIn('status', ['enabled'])->whereNull('name')->orWhere('name', '')->whereNull('code')->orWhere('code', '')->get();
        if ($designs->count() > 0) {
            ConsoleOutput::title('[Design] information ('.$designs->count().')');
            foreach ($designs as $design) {
                ConsoleOutput::info($design->id.' ');
            }
            ConsoleOutput::newLine();
        }
    }

    /**
     * Checks designs without tags (design gallery)
     */
    public function checkDesignNoTags()
    {
        $designs = Design::query()->whereIn('status', ['enabled'])->whereDoesntHave('tags')->get();
        if ($designs->count() > 0) {
            ConsoleOutput::title('[Design] No Tags ('.$designs->count().')');
            foreach ($designs as $design) {
                ConsoleOutput::info($design->id.' ');
            }
            ConsoleOutput::newLine();
        }
    }

    /**
     * Checks designs without any image (design gallery)
     */
    public function checkDesignNoImages()
    {
        $designs = Design::query()->whereIn('status', ['enabled'])->whereDoesntHave('images')->get();
        if ($designs->count() > 0) {
            ConsoleOutput::title('[Design] No Images ('.$designs->count().')');
            foreach ($designs as $design) {
                ConsoleOutput::info($design->id.' ');
            }
            ConsoleOutput::newLine();
        }
    }

    /**
     * Checks designs with untrimmed tags (design gallery)
     */
    public function checkDesignTagTrim()
    {
        $designs = DesignTag::query()->where(DB::raw('trim(name)'), '<>', DB::raw('name'))->get();
        if ($designs->count() > 0) {
            ConsoleOutput::title('[Design] Not Trimmed ('.$designs->count().')');
            if ($this->fix) {
                ConsoleOutput::info('Fixing');
                foreach ($designs as $design) {
                    $design->update([
                        'name' => trim($design->name),
                    ]);
                    ConsoleOutput::info('.');
                }
                ConsoleOutput::newLine();
            }
            foreach ($designs as $design) {
                ConsoleOutput::info($design->id.' ');
            }
            ConsoleOutput::newLine();
        }
    }

    /**
     * Checks chapters with untrimmed names
     */
    public function checkChapterTrim()
    {
        $chapters = Chapter::query()->where(DB::raw('trim(name)'), '<>', DB::raw('name'))->get();
        if ($chapters->count() > 0) {
            ConsoleOutput::title('[Chapter] Not Trimmed ('.$chapters->count().')');
            if ($this->fix) {
                ConsoleOutput::info('Fixing');
                foreach ($chapters as $chapter) {
                    $chapter->update([
                        'name' => trim($chapter->name),
                    ]);
                    ConsoleOutput::info('.');
                }
                ConsoleOutput::newLine();
            }
            foreach ($chapters as $chapter) {
                ConsoleOutput::info($chapter->id.' ');
            }
            ConsoleOutput::newLine();
        }
    }

    /**
     * Checks schools with untrimmed names
     */
    public function checkSchoolTrim()
    {
        $schools = School::query()->where(DB::raw('trim(name)'), '<>', DB::raw('name'))->get();
        if ($schools->count() > 0) {
            ConsoleOutput::title('[School] Not Trimmed ('.$schools->count().')');
            if ($this->fix) {
                ConsoleOutput::info('Fixing');
                foreach ($schools as $school) {
                    $school->update([
                        'name' => trim($school->name),
                    ]);
                    ConsoleOutput::info('.');
                }
                ConsoleOutput::newLine();
            }
            foreach ($schools as $school) {
                ConsoleOutput::info($school->id.' ');
            }
            ConsoleOutput::newLine();
        }
    }
}
