<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChapterOrganizationsTable extends Migration
{
    private $data = [
        ['name' => 'Acacia', 'acronym' => 'Acacia', 'segment' => 'IFC'],
        ['name' => 'Alpha Chi Rho', 'acronym' => 'AXP', 'segment' => 'IFC'],
        ['name' => 'Alpha Delta Gamma', 'acronym' => 'AGD', 'segment' => 'IFC'],
        ['name' => 'Alpha Delta Phi', 'acronym' => 'ΑΔΦ', 'segment' => 'IFC'],
        ['name' => 'Alpha Epsilon Pi', 'acronym' => 'ΑΕΠ', 'segment' => 'IFC'],
        ['name' => 'Alpha Gamma Rho', 'acronym' => 'ΑΓΡ', 'segment' => 'IFC'],
        ['name' => 'Alpha Gamma Sigma', 'acronym' => 'ΑΓΣ', 'segment' => 'IFC'],
        ['name' => 'Alpha Kappa Lambda', 'acronym' => 'ΑΚΛ', 'segment' => 'IFC'],
        ['name' => 'Alpha Phi Alpha', 'acronym' => 'ΑΦΑ', 'segment' => 'IFC'],
        ['name' => 'Alpha Phi Delta', 'acronym' => 'ΑΦΔ', 'segment' => 'IFC'],
        ['name' => 'Alpha Sigma Phi', 'acronym' => 'ΑΣΦ', 'segment' => 'IFC'],
        ['name' => 'Alpha Tau Omega', 'acronym' => 'ΑΤΩ', 'segment' => 'IFC'],
        ['name' => 'Beta Chi Theta', 'acronym' => 'ΒΧΘ', 'segment' => 'IFC'],
        ['name' => 'Beta Sigma Psi', 'acronym' => 'ΒΣΨ', 'segment' => 'IFC'],
        ['name' => 'Beta Theta Pi', 'acronym' => 'ΒΘΠ', 'segment' => 'IFC'],
        ['name' => 'Beta Upsilon Chi', 'acronym' => 'ΒΥΧ', 'segment' => 'IFC'],
        ['name' => 'Chi Phi', 'acronym' => 'ΧΦ', 'segment' => 'IFC'],
        ['name' => 'Chi Psi', 'acronym' => 'ΧΨ', 'segment' => 'IFC'],
        ['name' => 'Delta Chi', 'acronym' => 'ΔΧ', 'segment' => 'IFC'],
        ['name' => 'Delta Kappa Epsilon', 'acronym' => 'ΔΚΕ', 'segment' => 'IFC'],
        ['name' => 'Delta Lambda Phi[17]', 'ΔΛΦ', 'segment' => 'IFC'],
        ['name' => 'Delta Phi', 'acronym' => 'ΔΦ', 'segment' => 'IFC'],
        ['name' => 'Delta Psi', 'acronym' => 'ΔΨ', 'segment' => 'IFC'],
        ['name' => 'Delta Sigma Phi', 'acronym' => 'ΔΣΦ', 'segment' => 'IFC'],
        ['name' => 'Delta Tau Delta', 'acronym' => 'ΔΤΔ', 'segment' => 'IFC'],
        ['name' => 'Delta Upsilon', 'acronym' => 'ΔΥ', 'segment' => 'IFC'],
        ['name' => 'Iota Nu Delta', 'acronym' => 'ΙΝΔ', 'segment' => 'IFC'],
        ['name' => 'Iota Phi Theta', 'acronym' => 'ΙΦΘ', 'segment' => 'IFC'],
        ['name' => 'Kappa Alpha Order', 'acronym' => 'KA', 'segment' => 'IFC'],
        ['name' => 'Kappa Alpha Psi', 'acronym' => 'ΚΑΨ', 'segment' => 'IFC'],
        ['name' => 'Kappa Alpha Society', 'acronym' => 'KA', 'segment' => 'IFC'],
        ['name' => 'Kappa Delta Phi', 'acronym' => 'ΚΔΦ', 'segment' => 'IFC'],
        ['name' => 'Kappa Delta Rho', 'acronym' => 'ΚΔΡ', 'segment' => 'IFC'],
        ['name' => 'Lambda Phi Epsilon', 'acronym' => 'ΛΦΕ', 'segment' => 'IFC'],
        ['name' => 'Lambda Sigma Upsilon', 'acronym' => 'ΛΣΥ', 'segment' => 'IFC'],
        ['name' => 'Lambda Theta Phi', 'acronym' => 'ΛΘΦ', 'segment' => 'IFC'],
        ['name' => 'Nu Alpha Kappa', 'acronym' => 'NAK', 'segment' => 'IFC'],
        ['name' => 'Omega Delta Phi', 'acronym' => 'ΩΔΦ', 'segment' => 'IFC'],
        ['name' => 'Phi Beta Sigma', 'acronym' => 'ΦΒΣ', 'segment' => 'IFC'],
        ['name' => 'Phi Gamma Delta ', 'acronym' => 'ΦΓΔ', 'segment' => 'IFC'],
        ['name' => 'Phi Iota Alpha ', 'acronym' => 'ΦΙΑ', 'segment' => 'IFC'],
        ['name' => 'Phi Kappa Psi ', 'acronym' => 'ΦΚΨ', 'segment' => 'IFC'],
        ['name' => 'Phi Kappa Sigma ', 'acronym' => 'ΦΚΣ', 'segment' => 'IFC'],
        ['name' => 'Phi Kappa Tau ', 'acronym' => 'ΦΚΤ', 'segment' => 'IFC'],
        ['name' => 'Phi Kappa Theta ', 'acronym' => 'ΦΚΘ', 'segment' => 'IFC'],
        ['name' => 'Phi Lambda Chi ', 'acronym' => 'ΦΛΧ', 'segment' => 'IFC'],
        ['name' => 'Phi Mu Delta ', 'acronym' => 'ΦΜΔ', 'segment' => 'IFC'],
        ['name' => 'Phi Sigma Kappa ', 'acronym' => 'ΦΣΚ', 'segment' => 'IFC'],
        ['name' => 'Phi Sigma Phi ', 'acronym' => 'ΦΣΦ', 'segment' => 'IFC'],
        ['name' => 'Pi Kappa Alpha ', 'acronym' => 'ΠΚΑ', 'segment' => 'IFC'],
        ['name' => 'Pi Kappa Phi ', 'acronym' => 'ΠΚΦ', 'segment' => 'IFC'],
        ['name' => 'Pi Lambda Phi ', 'acronym' => 'ΠΛΦ', 'segment' => 'IFC'],
        ['name' => 'Psi Upsilon ', 'acronym' => 'ΨΥ', 'segment' => 'IFC'],
        ['name' => 'Sigma Alpha Epsilon ', 'acronym' => 'ΣΑΕ', 'segment' => 'IFC'],
        ['name' => 'Sigma Alpha Mu ', 'acronym' => 'ΣΑΜ', 'segment' => 'IFC'],
        ['name' => 'Sigma Beta Rho ', 'acronym' => 'ΣΒΡ', 'segment' => 'IFC'],
        ['name' => 'Sigma Chi ', 'acronym' => 'ΣΧ', 'segment' => 'IFC'],
        ['name' => 'Sigma Lambda Beta ', 'acronym' => 'ΣΛΒ', 'segment' => 'IFC'],
        ['name' => 'Sigma Nu ', 'acronym' => 'ΣΝ', 'segment' => 'IFC'],
        ['name' => 'Sigma Phi ', 'acronym' => 'ΣΦ', 'segment' => 'IFC'],
        ['name' => 'Sigma Phi Epsilon ', 'acronym' => 'ΣΦΕ', 'segment' => 'IFC'],
        ['name' => 'Sigma Pi ', 'acronym' => 'ΣΠ', 'segment' => 'IFC'],
        ['name' => 'Sigma Tau Gamma ', 'acronym' => 'ΣΤΓ', 'segment' => 'IFC'],
        ['name' => 'Tau Delta Phi ', 'acronym' => 'ΤΔΦ', 'segment' => 'IFC'],
        ['name' => 'Tau Epsilon Phi ', 'acronym' => 'ΤΕΦ', 'segment' => 'IFC'],
        ['name' => 'Tau Phi Sigma ', 'acronym' => 'ΤΦΣ', 'segment' => 'IFC'],
        ['name' => 'Theta Chi ', 'acronym' => 'ΘΧ', 'segment' => 'IFC'],
        ['name' => 'Theta Delta Chi ', 'acronym' => 'ΘΔΧ', 'segment' => 'IFC'],
        ['name' => 'Theta Xi ', 'acronym' => 'ΘΞ', 'segment' => 'IFC'],
        ['name' => 'Zeta Beta Tau ', 'acronym' => 'ΖΒΤ', 'segment' => 'IFC'],
        ['name' => 'Zeta Psi ', 'acronym' => 'ΖΨ', 'segment' => 'IFC'],
        ['name' => 'Delta Epsilon Psi ', 'acronym' => 'ΔΕΨ', 'segment' => 'IFC'],
        ['name' => 'Kappa Sigma ', 'acronym' => 'ΚΣ', 'segment' => 'IFC'],
        ['name' => 'Lambda Chi Alpha ', 'acronym' => 'ΛΧΑ', 'segment' => 'IFC'],
        ['name' => 'Phi Delta Theta ', 'acronym' => 'ΦΔΘ', 'segment' => 'IFC'],
        ['name' => 'Tau Kappa Epsilon ', 'acronym' => 'TKE', 'segment' => 'IFC'],
        ['name' => 'Alpha Chi Omega', 'acronym' => 'ΑΧΩ', 'segment' => 'Panhellenic'],
        ['name' => 'Alpha Delta Pi', 'acronym' => 'ΑΔΠ', 'segment' => 'Panhellenic'],
        ['name' => 'Alpha Epsilon Phi', 'acronym' => 'ΑΕΦ', 'segment' => 'Panhellenic'],
        ['name' => 'Alpha Gamma Delta', 'acronym' => 'ΑΓΔ', 'segment' => 'Panhellenic'],
        ['name' => 'Alpha Omicron Pi', 'acronym' => 'ΑΟΠ', 'segment' => 'Panhellenic'],
        ['name' => 'Alpha Phi', 'acronym' => 'ΑΦ', 'segment' => 'Panhellenic'],
        ['name' => 'Alpha Sigma Alpha', 'acronym' => 'ΑΣΑ', 'segment' => 'Panhellenic'],
        ['name' => 'Alpha Sigma Tau', 'acronym' => 'ΑΣΤ', 'segment' => 'Panhellenic'],
        ['name' => 'Alpha Xi Delta', 'acronym' => 'ΑΞΔ', 'segment' => 'Panhellenic'],
        ['name' => 'Chi Omega', 'acronym' => 'ΧΩ', 'segment' => 'Panhellenic'],
        ['name' => 'Delta Delta Delta', 'acronym' => 'ΔΔΔ', 'segment' => 'Panhellenic'],
        ['name' => 'Delta Gamma', 'acronym' => 'ΔΓ', 'segment' => 'Panhellenic'],
        ['name' => 'Delta Phi Epsilon', 'acronym' => 'ΔΦΕ', 'segment' => 'Panhellenic'],
        ['name' => 'Delta Zeta', 'acronym' => 'ΔΖ', 'segment' => 'Panhellenic'],
        ['name' => 'Gamma Phi Beta', 'acronym' => 'ΓΦΒ', 'segment' => 'Panhellenic'],
        ['name' => 'Kappa Alpha Theta', 'acronym' => 'ΚΑΘ', 'segment' => 'Panhellenic'],
        ['name' => 'Kappa Delta', 'acronym' => 'ΚΔ', 'segment' => 'Panhellenic'],
        ['name' => 'Kappa Kappa Gamma', 'acronym' => 'ΚΚΓ', 'segment' => 'Panhellenic'],
        ['name' => 'Phi Mu', 'acronym' => 'ΦΜ', 'segment' => 'Panhellenic'],
        ['name' => 'Phi Sigma Sigma', 'acronym' => 'ΦΣΣ', 'segment' => 'Panhellenic'],
        ['name' => 'Pi Beta Phi', 'acronym' => 'ΠΒΦ', 'segment' => 'Panhellenic'],
        ['name' => 'Sigma Delta Tau', 'acronym' => 'ΣΔΤ', 'segment' => 'Panhellenic'],
        ['name' => 'Sigma Kappa', 'acronym' => 'ΣΚ', 'segment' => 'Panhellenic'],
        ['name' => 'Sigma Sigma Sigma', 'acronym' => 'ΣΣΣ', 'segment' => 'Panhellenic'],
        ['name' => 'Theta Phi Alpha', 'acronym' => 'ΘΦΑ', 'segment' => 'Panhellenic'],
        ['name' => 'Zeta Tau Alpha', 'acronym' => 'ΖΤΑ', 'segment' => 'Panhellenic'],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('chapter_organizations')) {
            Schema::create('chapter_organizations', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('acronym');
                $table->string('segment');
                $table->timestamps();
            });
        }

        foreach ($this->data as $entry) {
            DB::insert('insert into chapter_organizations (name, acronym, segment) values (?, ?, ?)', array_values($entry));
        }

        Schema::table('work_with_us', function (Blueprint $table) {
            $table->string('are_you_ready')->nullable()->after('size');
            $table->string('minimum_guarantee')->nullable()->after('are_you_ready');
        });

        DB::update('update work_with_us set size = 151 where size = 5');
        DB::update('update work_with_us set size = 121 where size = 4');
        DB::update('update work_with_us set size = 81 where size = 3');
        DB::update('update work_with_us set size = 51 where size = 2');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chapter_organizations');

        if (Schema::hasColumn('work_with_us', 'are_you_ready')) {
            Schema::table('work_with_us', function (Blueprint $table) {
                $table->dropColumn('are_you_ready');
                $table->dropColumn('minimum_guarantee');
            });

            DB::update('update work_with_us set size = 5 where size >= 151');
            DB::update('update work_with_us set size = 4 where size >= 121');
            DB::update('update work_with_us set size = 3 where size >= 81');
            DB::update('update work_with_us set size = 2 where size >= 51');
            DB::update('update work_with_us set size = 1 where size >= 6');
        }
    }
}
