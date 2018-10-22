<?php

class DesignTagGroupSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        design_tag_group_repository()->create([
            'code'      => 'general',
            'caption'   => 'General',
            'whitelist' => null,
        ]);
        design_tag_group_repository()->create([
            'code'      => 'themes',
            'caption'   => 'Themes',
            'whitelist' => '20\'s,60\'s,70\'s,80\'s,90\'s,Alumnae/Alumni,American/USA,Anchor,Animal Print,Animal,Anniversary,Army/Military/Camo,Arrowspike,Athletic/Sports/Intramurals,Bachelorette/Wedding,Ballet,Band Party,Banquet,Barn/Western/Hay Ride,Beach,Boat/Riverboat/Cruise/Nautical,Bows/Ties,Breast Cancer/Make-a-Wish,Brotherhood,Business/Corporate,Camps and Clubs,Carnival,Carnval Games,Casino/Vegas,Chevron,Church/Religious,Circus,Classic Rock,Crest/Shield/Symbols,Crush/Krush,Dance,Disney,Easter,Executive Board,Fall,Family Weekend,Floral,Foil,Food,Food Function,Fraternity,Game/Trivia Night,Geometric,Go Greek/Greek Week/Greek Weekend,High School,Hippie,Holiday,Hollywood,Home,House,Infinity,Just for Fun,Love,Luau,Mai Tai,Mandalas,Mardi Gras/Masquerade,Mascot,Metallic,Mexican,Midwest,Movies/TV Theme,Mud Wrestling,Music,Natural,Neon,Original Paterns,Pagent,Palm Tree,Pancake Party,Panhellenic,Patriotic,Picnic,Pineapple,Pledge,Pocket Stickers,Powderpuff,PR,Preppy,Presents,Retro/Neon,Rose Ball,School Spirit,Seniors,Shamrock,Sib\'s Weekend,Simple,Sisterhood,Skulls,Southern,Spring,Spring Fling,State Designs/Greek,State Designs/Maps,State Specific,Streetwear,Stripes,Summer,Talent Show,Tie Dye,Toga,Tribal,Tropical,Vintage,Watermelon,Watermelon Bust,Western,Wing Fling,Winter,Winter Holidays,Wish Week,Woolly Threads,Wreath',
        ]);
        design_tag_group_repository()->create([
            'code'      => 'event',
            'caption'   => 'Event',
            'whitelist' => 'Anchor Splash,Bar Crawl,Bid Day,Big Little,Christmas,Dad\'s Day,Dad\'s Weekend,Dance Marathon,Date Night/Date Party/Grab a Date,Derby Days,Feathers,Formal,Founders Day,Fundraiser,Gameday/Tailgate,Halloween,Homecoming,Initiation,Lip Sync,Mixers & Socials,Mom\'s Day,Mom\'s Weekend,Mountain Weekend,Mr/Mrs. Greek,New Member Retreat,Parents Weekend,Philanthropy,Recruiment,Relay 4 Life,Retreat,Rush,Slope Day,Social/Mixer/Swap,Songfest,Spirit Week,Spring Break,Crush,Spring Day,St. Jude,St. Patricks Day,Stars and Crescent Ball,Tailgate,Thanksgiving,Think Pink,Turtle Tug,Valentine\'s Day,Weekend Getaway,Welcome Week,Work Week,Intramural,Sisterhood retreat,BBQ,Woodser',
        ]);
        design_tag_group_repository()->create([
            'code'      => 'college',
            'caption'   => 'College/University',
            'whitelist' => 'University of Illinois,Pennsylvania State Univeristy,Purdue Univeristy,Virginia Tech University,Cornell University,Indiana University-Bloomington,University of Michigan, Ann Arbor,University of Alabama,Auburn University,University of Florida,Florida State University,University of Virginia,Miami University-Oxford,University of Georgia,University of Maryland,University of Washington-Seattle,University of Missouri,Arizona State University,Georgia Institute of Technology,Rutgers University,University of California, Berkley,University of Arizona,The University of Texas at Austin,University of Pennsylvania,University of Wisconsin-Madison,University of Nebraska-Lincoln,University of Kentucky,Iowa State University,University of Minnesota,North Carolina State University,Syracuse University,Michigan State University,University of Central Florida,Texas A & M University-College Station,University of Kansas,University of North Carolina at Chapel Hill,Texas Tech University,University of California, Los Angeles,The University Of Tennessee Knoxville,Louisiana State University,Kansas State University,University of Delaware,Oregon State University,Oklahoma State University,Washington State University,Vanderbilt Unversity,University of Oklahoma,Bowling Green State University,University of South Carolina,James Madison University,University of Southern California,University of South Florida,San Diego State University,Northwestern University,Clemson University,University of Cincinnati,University of Mississippi,Illinois State Univeristy,Case Western Reserve University,George Washington University,Virginia Commonwealth University,Univeristy of Arkansas,University of North Texas,Stephen F Austin State University,Rensselaer Polytechnic Institute,West Virginia University,University of California, Davis,Ohio University,University of Colorado Boulder,Buffalo State, The State University of New York,Georgia Southern University,Mississipi State university,College of William & Mary,University of Houston,Baylor University,University of Iowa,Northern Illinois University,University of Connecticut,University of Miami,East Carolina University,Western Kentucky University,University of Oregon,Kent State University,Lehigh University,Florida International University,University of North Carolina at Charlotte,Missouri State University,Washington University in St Louis,University of Idaho,Texas Christian University,Western Michigan University,University of Pittsburgh-Pittsburgh Campus,College of Charleston,Middle Tennessee State University,University of North Carolina at Willmington,Radford University,Eastern Kentucky University,Northwestern Missouri State University,Southeast Missouri State University,California State University, Long Beach,Western Illinois University,Towson University,University of Southern Mississippi,University of Louisville,Ball State University,American University,University of Rochester,Tulane University,Appalachian State University,University of Nevada, Las Vegas,University of Toledo,Colorado State University,University of Rhode Island,Florida Atlantic University,University of Memphis,Texas State University-San Marcos,Temple University,Drexel University,Massachusetts Institute of Technology,University of West Georgia,California State University, Sacramento,San Jose State University,The University of Texas at San Antonio,Southern Methodist University,Indiana State University,Central Michigan University,Eastern Michigan University,Villanova University,Boston University,University at Buffalo, The State University of New York,Valdosta State University,Western Carolina University,George Mason University,University of Central Missouri,California State University, Northridge,Sam Houston State University,West Chester University of Pennsylvania,Indiana University of Pennsylvania,University of Louisiana,Longwood University,The University of Texas at Arlington,University of Wisconsin, Oshkosh,University of Chicago,Bradley University,Ferris State University,University of Akron Main Campus,Shippensburg University of Pennsylvania,University of Maine,The College of New Jersey,Johns Hopkins University,Troy Univeristy,University of North Florida,Murray State University,University of Dayton,Universtiy of Massachusetts Amherst,Rowan University,University of Alabama, Birmingham,University of South Alabama,Georgia State University,Emory University,Morehead State University,Arkansas State University,Northern Arizona University,Souther Illinois University Carbondale,Carnegie Mellon University,New York University,Richard Stockton College of New Jersey,Kennesaw State University,Southeastern Louisiana University,California State University, Fullerton,Texas A & M University-Commerce,New Mexico State University,Wichita State University,Pittsburg State University,University of North Dakota,DePaul University,Wayne State University,Duquesne University,Edinboro University,Northeastern University,Stony Brook University,Columbia University,Seton Hall University,Georgia College & State University,Northwestern State University of Louisiana,University of North Carolina at Greensboro,Christopher Newport University,Northern Kentucky University,Missouri University of Science and Technology,Lamar University,Drake University,Indiana University-Purdue University-Indianapolis,Grand Valley State University,California University of Pennsylvania,University of New Hampshire,McNeese State University,Univeristy of Richmond,San Francisco State University,Eastern Washington University,University of Wisconsin, Whitewater,University of Illinois at Chicago,Southern Illinois University Edwardsville,Wright State Univeristy,Worcester Polytechnic Institute,Rutgers University Newark,Kean University,Ramapo College of New Jersey,University of Maryland, Baltimore County,University of Nevada, Reno,The University of Texas at Dallas,University of Nebraska, Omaha,Loyola University Chicago,Michigan Technological University,Hofstra University,Adelphi University,Rutgers University Camden,Fairleigh Dickinson University, Metropolitan,Austin Peay State University,University of Missouri, Kansas City,Loyola Marymount University,Tarleton State University,North Dakota State University,Butler University,Cleveland State University,Youngstown State University,University of Northern Colorado,Yale University,University of Hartford,State University of New York at Plattsburg,Louisiana Tech University,University of New Orleans,Boise State University,University of Utah,Emporia State University,Creighton University,University of South Dakota,University of Wisconsin-Milwaukee,Valparaiso University,Baldwin Wallace University,University of Wyoming,Tufts University,New Jersey Institute of Technology,Frostburg State University,Wofford College,University of Arkansas at Little Rock,Pepperdine University,University of New Mexico,University of Tulsa,Robert Morris University,University of Michigan-Dearborn,University of Vermont,State University of New York at Old Westbury,State University of New York at Oswego,Monmouth University,Stevens Institute of Technology,Salisbury University,Henderson State University,The University of Texas at El Paso,University of Central Oklahoma,Minnesota State University, Mankato,University of Souther Indiana,Oakland University,Fairleigh Dickinson University, College at Florham,Florida Gulf Coast University,University of North Georgia,University of Central Arkansas,University of Arkansas at Monticello,Texas A & M University-Corpus Christi,Prairie View A & M University,Washburn University,University of Nebraska Kearney,South Dakota State University,Marquette University,Saginaw Valley State University,University of Detroit Mercy,University of Montana,Montana State University,Widener University,Bentley University,Sacred Heart University,State University of New York at New Paltz,Rider University,Missouri Western State University,Texas Southern University,North Eastern State University,University of Wisconsin, Platteville,Capital University,Lock Haven University,Brown University,Clarkson University,Virginia State University,Norfolk State University,West Virginia Wesleyan College,California State University, Los Angeles,The University of Texas-Pan American,Texas A & M University-Kingsville,University of the Incarnate Word,West Texas A & M University,University of Northern Iowa,Lewis University,Indiana University-Southeast,Ashland University,East Stroudsburg University of Pennsylvania,La Salle University,State University of New York College at Cortland,New Jersey City University,Florida Agricultural and Mechanical University,Virginia Wesleyan College,Arkansas Tech University,Drury University,Oklahoma City University,Fort Hays State University,Baker University,University of Wisconsin, River Falls,Roosevelt University,Colorado School of Mines,Howard University,University of New Haven,Marist College,University of Maryland Eastern Shore,University of Virginia, Wise,Hampton University,University of Arkansas-Fort Smith,University of Missouri St. Louis,Portland State University,The University of Texas at Tyler,Angelo State University,East Central University,Southeastern Oklahoma State University,University of Wisconsin, Eau Claire,Northern Michigan University,Xavier University,Colorado College,Keene State College,Harvard university,University of Massachusetts Dartmouth,Brandeis University,Southern Connecticut State University,City College of New York,State University of New York at Oneonta,State University of New York in Brockport,McDaniel College,The College of Idaho,Utah State University,Cameron University,Minnesota State University Moorhead,University of Wisconsin, La Crosse,Indiana University-South Bend,Georgetown University,University of Southern Maine,Missouri Valley College,Western Oregon University,Eastern New Mexico University,Southwestern Oklahoma State University,Wesley College,Idaho State University,University of Colorado at Colorado Springs,West Virginia Institute of Technology,Southern Utah University,Southern New Hampshire University,Utah Valley University,Colorado Mesa University,Virginia Technical University,Binghamton University State University of New York,University of Wisconsin, Parkside,Oregon Institute of Technology,Middlebury College,Cal Poly, SLO,Mississippi State University,University of Texas, San Antonio,Loyola University of New Orleans',
        ]);
        design_tag_group_repository()->create([
            'code'      => 'chapter',
            'caption'   => 'Chapter',
            'whitelist' => 'Kappa Delta,Alpha Delta Phi,Delta Delta Delta,Delta Sigma Theta,Sigma Delta Tau,Delta Sigma Pi,ALPHA CHI OMEGA,ALPHA XI DELTA,ALPHA EPSILON PHI,CHI OMEGA,DELTA GAMMA,PHI MU,Alpha Epsilon Pi,Alpha Sigma Phi,Delta Chi,Delta Tau Delta,Lamba Chi Alpha,Sigma Phi Epsilon,Zeta Beta Tau,Delta Zeta,Sigma Kappa,Kappa Delta Rho,Lambda Chi Alpha,Pi Kappa Alpha,Tau Kappa Epsilon,Alpha Delta Pi,Alpha Phi,Zeta Tau Alpha,Sigma Alpha Epsilon,Alpha Tau Omega,Kappa Sigma,Delta Chi Home,Phi Gamma Delta,Delta Sigma Phi (Colony),Phi Kappa University,Theta Chi,Alpha Gamma Delta,Alpha Omicron Pi,Sigma Chi,Sigma Pi,Alpha Phi Alpha,Phi Lambda Chi,Theta Phi Alpha,Phi Delta Theta,Phi Kappa Psi,Kappa Alpha Theta,Kappa Kappa Gamma,Alpha Gamma Rho,Alpha Psi,Beta Theta Pi,Chi Phi,Delta Kappa Epsilon,Delta Sigma Phi,Farmhouse,Kappa Alpha Order,Phi Kappa Tau,Phi Sigma Kappa,Pi Kappa Phi,Sigma Nu,Sigma Tau Gamma,Theta Xi,Alpha Sigma Alpha,Kappa Alpa Psi,Omega Psi Phi,Zeta Phi Beta,Alpha Kappa Alpha,Pi Lambda Phi,Gamma Phi Omega Sorority, Inc.,Gamma Rho Lambda,Pi Beta Phi,Phi Mu Alpha,Alpha Delta Pi,,Kappa Kappa Gamma,,Zeta Tau Alpha,,Phi Iota Alpha,Phi Sigma Sigma,Alpha Gamma Pi,Tau Epsilon Phi,Alpha Pi Sigma,Lambda Theta Alpha,Sigma Lambda Gamma,Alpha Kappa Delta Phi,Gamma Phi Beta,Delta Lambda Phi,Alpha Epsilon Pi (AE_),Delta Upsilon,Delta Phi Epsilon,Kappa Beta Gamma,Sigma Alpha Mu,Xi Kappa,Theta Delta Chi,delta Delta Phi Zeta,Zeta Chi Omega,Sigma Gamma Rho,Chi Sigma Phi,Lambda Theta Nu,Sigma Lambda Beta,Lambda Theta Phi,Gamma Zeta Alpha,Phi Lambda Rho,Delta Lambda Chi,Rho Delta Chi,Tau Omega Rho,Alpha Sigma Tau,Alpha Kappa Lambda,Sigma Alpha Omega,Omega Zeta Theta,Pi Phi Epsilon,Sigma Alpha Beta,Lambda Phi Epsilon,Carnegie Mellon University,Phi Sigma Rho,Sigma Psi,Zeta Psi,Gamma Nu Delta,Lambda Pi Chi,Sigma Rho Phi,Iota Nu Delta,Phi Beta Sigma,Kappa Delta Chi,Alpha Chi Rho,Omicron Pi Omicron,Phi Kappa Sigma,Zeta Nu,Beta Upsilon Chi,Chi Psi,Triangle,Kappa Kapppa Gamma,Delta Phi,Kappa Alpha,Alpha Delta Chi,Alpha Sigma Kappa,Kappa Delta Chi Sorority,Lambda Theta Nu Sorority,Sigma Alpha,Alpha Gamma Omega,Phi Kappa Theta,ACACIA,Alpha Phi Delta,Sigma Chi__,Phi Gamma Delta (FIJI),Chi Upsilon Sigma Latin,Delta Phi Omega,Kappa Phi Gamma,Sigma Sigma Sigma,Alpha Phi Alpha Fraternity,Beta Theta Pi Fraternity,Delta Epsilon Psi Fraternity,Alpha Delta,Gamma Phi,Lota Phi Theta,Alpha Phi,,Mu Sigma Upsilon,Kappa Alpha Psi,Omega Delta Phi,Lambda Tau Omega,Lambda Pi Upsilon,Lambda Kappa Sigm,Iota Phi Theta,Alpha Nu Omega Sorority,Delta Sigma ThetaXi Epsilon,Phi Mu kappa Rho,Sigma Gamma Rho Sorority,Zeta Phi Beta Sorority, Pi Eta,Alpha Nu Omega Fraternity,Kappa Alpha Psi Fraternity,Lambda Theta Phi Fraternity,Phi Mu Alpha Sinfonia,Phi Mu Delta,ALPHA OMEGA EPSILON,Psi Upsilon,Triangle Fraternity,Alpha Theta Beta,Acacia Fraternity,Kappa Sigma Fraternity,Phi Delta Theta Fraternity,Phi Kappa Psi Fraternity,Phi Kappa Tau Fraternity,Phi Mu Delta Fraternity,Sigma Chi Fraternity,Sigma Pi Fraternity,Alpha Epsilon Ph,Alpha PI,Phi Beta Phi,Beta Sigma Psi,Sigma Beta Rho,Sigma Phi Beta,Gamma Eta,Alpha Chi Omega - Delta Nu,Alpha Omicron Pi - Iota Sigma,Sigma Alpha Epsilon Pi,Sigma Phi Delta,Delta Xi Phi,Alpha Theta Alpha,Sigma Phi Lambda,Gamma Psi,Kappa Lambda Psi,Delta Psi / No.6,Kappa Sigma Gamma Pi,Nu Delta,Phi Beta Epsilon,Phi Alpha Mu,Alpha Kappa Psi,Alpha Delta Alpha,Phi Delta Chi,Theta Chi Epsilon,Kappa Delta Psi,Xi Omicron Iota,Alpha Gamma Sigma,Tau Delta Phi,Alpha Sigma PhiMichael Filosa,Alpha Phi Omega,Sigma Psi Kappa,Kappa Xi Kappa,Kappa Alpha Order*,Sigma Pi*,Kappa Psi,Alpha Kappa Sigma,Delta Chi Lambda,Gamma Alpha Omega,FIJI,Sigma Lambda Sigma,OMEGA DELTA,PHI KAPPA PSI,,Alpha Chi Omega Sorority,Delta Gamma Fraternity,Chi Omega Fraternity,Gamma Phi Beta Sorority,Delta Delta Delta Fraternity,Evans Scholars,Farm House,FIJI/Phi Gamma Delta,Sigma Omicron Pi,Alpha Rho Chi,Alpha Gmma Delta,Beta Chi Theta,Beta Kappa Sigma,Chi Upsilon Sigma,Omega Phi Beta,Gamma Phi Omega,Omega Phi Kappa,Ceres,Omega Zeta Pi,Beta Mu Sigma,Lambda Alpha Upsilon,Kappa Delta Phi, NAS Sorority,Phi Delta Beta,Delta Psi Omega,Sigma Sigma Chi,Zeta Phi,Kappa Delta Omega,Theta Alpha Omega,Alpha Kappa Phi,Sigma Iota Alpha,Sigma Lambda Upsilon,Lambda Upsilon Lambda,Pi Alpha Nu,Lambda Sigma Upsilon,Pi Delta Chi,Sigma Gamma Phi,Alpha Delta Eta,Omicron Xi,Phi Lambda Phi,Psi Phi Gamma,Sigma Tau Chi,Zeta Chi Zeta,Mu Beta Psi,Theta Alpha Lambda,Theta Nu Xi,Theta Gamma,Alpha Gamma Delta Sorority,Alpha Xi Delta Sorority,Delta Phi Epsilon Sorority,Phi Sigma Sigma Sorority,Alpha Tau Omega Fraternity,Pi Kappa Alpha Fraternity,Theta Chi Fraternity,Lambda Chi Alpha,SIGMA EPSILON,Delta Epsilon Psi,Phi Alpha Delta,Alpha Sigma Rho,Sigma Phi Omega Sorority, Inc.,Zeta Phi Beta Sorority, Inc.,Phi Iota Alpha Fraternity, Inc,Sigma Kappa Phi,Sigma Chi Omega,Lone Star,Lambda Sigma Phi,Phi Beta Chi,Alpha Delta Chi,,Phi Sigma Rho,,Sigma Alpha Mu**,Alpha Epsilon Pi Chi Upsilon,Alpha Sigma Phi Pi,Chi Psi Psi Delta,Phi Kappa Tau Psi,Pi Kappa Phi Eta Gamma,Zeta Beta Tau Beta Alpha Theta,_appa Sigma,Alpha Psi Lambda,Chi Sigma Tau,Sigma Phi Dleta,Chi Sigma Omega,Lambda Zeta Chi,Pi Kappa Alpha (colony),Kappa Delta Phi NAS,AlphaDelta Pi,Alpha Epsion Pi,Omega Phi Psi,Phi Kappa Phi,Iota Delta Nu,Sigma Phi Rho,Phi Sigma Phi,Lambda Delta Phi,Chi Psi (ÒLodgeÓ),Delta Psi,Nu Alpha Kappa,Alpha Phi Gamma,Omega Delta sigma,Chi Kappa Rho,Kappa Gamma Rho,Kappa Kappa Gamm,Alpha Epsilon Pi (AEPi),Alpha Sigma Phi (Alpha Sig),Alpha Tau Omega (ATO),Beta Theta Pi (Beta),Chi Psi (The Lodge),Delta Kappa Epsilon (DKE),Delta Sigma Phi (Delta Sig),Delta Upsilon (DU),Kappa Alpha Order (KA),Kappa Sigma (Kappa Sig),Lambda Chi Alpha (Lambda Chi),Phi Delta Theta (Phi Delt),Phi Gamma Delta (Phi Gam),Pi Kappa Alpha (PiKA),Pi Kappa Phi (Pi Kapp),Pi Lambda Phi (Pi Lam),Sigma Alpha Epsilon (SAE),Sigma Phi,Sigma Phi Epsilon (Sig Ep),Zeta Beta Tau (ZBT),Zeta Psi (Zete),Alpha Delta Pi (ADPi),Delta Chi Fraternity,Delta Tau Delta (Delts),Sigma Omega,Sigma Mu Omega,Alpha Delta Phi Society,Delta Phi--St Elmo\'s Club,ZETA SIGMA CHI,Beta Theta Phi,Alpha Omricon Pi,Kappa Delta Phi,Delta Xi Nu,Delta Beta Chi,Delta Theta Sigma,Kappa Tau,Kappa Alpha Sigma,Sigma Alpha Iota,Phi Sigma,Alpha Sigma,Phi Chi Epsilon,Iota Gamma Upsilon,Alpha Tau Gamma,Pi Kappa Alpha (PIKE),Psi Sigma Phi,Pi Alpha Phi,Kappa Delta Sorority,Sigma Psi Zeta,Alpha Gamma Rho Fraternity,Lamda Chi Alpha,Alpha Epsilon Phi__,__Alpha Omicron Pi_,Alpha Phi_,_Chi Omega,_Delta Gamma,Pi Beta Phi__,Alpha Epsilon Pi_,_Theta Xi,Omega Psi Ch,Sigma Gamma Rho Sorority, Inc.,Alpha Epsilon Pi (colony),Phi Gamma Delta (colony),Delta Kappa Theta,Theta Nu Xi Multicultural,Gamma Sigma Sigma,Beta Phi Omega,TBD,Epsilon Kappa Theta,Kappa Delta Epsilon,Alpha Chi Alpha,Beta Alpha Omega,Bones Gate,Chi Gamma Epsilon,Chi Heorot,Gamma Delta Chi,Kappa Kappa Kappa,Phi Delta Alpha,Delta Phi Mu,Theta Xi Fraternity,Delta Sigma P,Theta Pi,Theta Tau,Pi Kappa Tau,Epsilon Omega,Kappa Phi,Delta Epsilon,Iota Iota,Psi Zeta,Alpha Kappa Delti Phi,Gamma Rho,Tri Sigma,Gamma Xi,Epsilon Rho,Gamma Beta,Epsilon Zeta,Alpha Kappa,Phi Delta Epsilon,Alpha Delta P,Tri Delta,Alpha Omicron P',
        ]);
        design_tag_group_repository()->create([
            'code'      => 'product_type',
            'caption'   => 'Product Type',
            'whitelist' => 'Short Sleeves,V-Necks,Tanks,Long Sleeves,Sweatshirts,Polo,Athletic Wear,Jersey,Bottoms,No Category,Accessories,Dresses,Jackets,Outdoors,Top Sellers,Flowy,Hats',
        ]);
    }
}