@extends('layouts.app')

@section('content')
<div class="row">
   <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">

                <div class="panel-body">
            <div class="panel-heading">
                <h3 class="panel-title">
                 <i class="fa fa-bar-chart-o fa-fw"></i>Student Registration</h3>
            </div>
            <div class="panel-body">

<?= Former::horizontal_open()
  ->id('MyForm')
  ->secure()
  ->rules(['name' => 'required'])
  ->method('POST') 
  ->actions()?>
<?php
    $schools = [
        'CPHR'	=>'Academy of Fashion Design',
        'CPHQ'	=>'Academy of Learning',
        'CPED'	=>'Academy of Learning',
        'CPHU'	=>'Academy of Learning Prince Albert',
        'CPAZ'	=>'Apex Academy of Professional Grooming and Animal Arts',
        'CPDH'	=>'Avant-Garde College',
        'CPAB'	=>'Bethany College',
        'CPAC'	=>'Briercrest College and Seminary',
        'CPAS'	=>'Canadian Revival Training Centre Inc.',
        'CJAA'	=>'Carlton Trail Regional College',
        'CZAA'	=>'College Mathieu',
        'CJAC'	=>'Cumberland Regional College',
        'CVAF'	=>'Dumont Technical Institute',
        'CPBH'	=>'Elite Hairstyling & Esthetics Training Center',
        'CPAG'	=>'Eston College',
        'CPCJ'	=>'Faith Alive Bible College',
        'CPCP'	=>'Faith College International',
        'CUAJ'	=>'First Nations University of Canada',
        'CUAL'	=>'Gabriel Dumont Institute',
        'CJAR'	=>'Great Plains College',
        'CPAO'	=>'Horizon College & Seminary',
        'CPHW'	=>'Leading Edge Aviation Limited',
        'CUAD'	=>'Lutheran Theological Seminary',
        'CPBC'	=>'Marvel Beauty School (Regina)',
        'CPBG'	=>'Marvel Beauty School (Saskatoon)',
        'CPDT'	=>'MC College',
        'CPBY'	=>'Mckay Career Training Inc.',
        'CPBA'	=>'Millar College of the Bible',
        'CPID'	=>'Millennium Aviation',
        'CPDN'	=>'Mitchinson Flying Service',
        'CPBD'	=>'Nipawin Bible College',
        'CPHJ'	=>'Nipawin Flight Center',
        'CJAG'	=>'North West Regional College',
        'CUAO'	=>'Northern Teacher Education Program Council Inc. (NORTEP)',
        'CJAF'	=>'Northlands College',
        'CJAI'	=>'Parkland Regional College',
        'CPEE'	=>'Professional Institute of Massage Therapy',
        'CPII'	=>'RCMP Training Academy',
        'CPBL'	=>'Regina Flying Club',
        'CPBE'	=>'Richards Beauty College',
        'CJAT'	=>'Saskatchewan Indian Institute of Technologies',
        'CVAH'	=>'Saskatchewan Polytechnic Moose Jaw Campus',
        'CVAU'	=>'Saskatchewan Polytechnic Prince Albert Campus',
        'CVAM'	=>'Saskatchewan Polytechnic Regina Campus',
        'CVAP'	=>'Saskatchewan Polytechnic Saskatoon Campus',
        'CVAE'	=>'Saskatchewan School of Radiation Therapy',
        'CPAM'	=>'Saskatoon Business College',
        'CVAB'	=>'Saskatoon Health Region Orthoptic Program',
        'CVAL'	=>'Saskatoon Public School Division',
        'CPAT'	=>'Saskatoon School of Horticulture',
        'CPAU'	=>'Saskatoon Spa Academy Ltd',
        'CJAM'	=>'Southeast Regional College',
        'CPAV'	=>'Southeast Aviation Services',
        'CUAI'	=>'St. Peters College',
        'CUAF'	=>'St. Andrew\'s College',
        'CPDZ'	=>'T & H Academies Career Training Centre',
        'CUAE'	=>'The College of Emmanuel & St. Chad',
        'CPAW'	=>'The Globe Theatre Conservatory',
        'CPAX'	=>'The Recording Arts Institute of Saskatoon',
        'CPEF'	=>'Timeless Instruments',
        'CUAB'	=>'University of Regina',
        'CUAG'	=>'University of Regina Campion College',
        'CUAH'	=>'University of Regina Luther College',
        'CUAC'	=>'University of Saskatchewan',
        'CPBN'	=>'Western Academy Broadcasting College Ltd',
        'CPHP'	=>'Western College of Remedial Massage Therapies Inc.',
    ]; 
    
    $study = [
        "agbio"=>'Agriculture and Bioresources',
        "arts_and_science"=>'Arts and Science',
        "business"=>'Edwards School of Business',
        "education"=>'Education',
        "engineering"=>'Engineering',
        "kinesiology"=>'Kinesiology',
        "st-thomas-more"=>'St. Thomas More',
        "dentistry"=>'Dentistry',
        "education"=>'Education',
        "law"=>'Law',
        "medicine"=>'Medicine',
        "nursing"=>'Nursing',
        "pharmacy"=>'Pharmacy and Nutrition',
        "vetmed"=>'Veterinary Medicine',
        "environment"=>'Environment and Sustainability',
        "graduate"=>'Graduate Studies',
        "physical_therapy"=>'Physical Therapy',
        "public_health"=>'Public Health',
        "public_policy"=>'Public Policy'
    ]; 
?>

  <?= Former::number('studentNumber', 'Student Number')->required() ,
        Former::password('password', 'New Password')->required(),
        Former::password('confirmPassword', 'Confirm New Password')->required(),
       Former::text('firstName', 'First Name')->required(),
       Former::text('lastName', 'Last Name')->required(),
       Former::number('age', 'Age')->min(0)->required(),
       Former::select('school', 'School')->options($schools, 'CUAC'),
       Former::select('areaOfStudy', 'Area Of Study')->options($study),
       Former::email('email')->required(),
        
       
       
      Former::actions()
    ->large_primary_submit('Submit')
    ->large_inverse_reset('Reset')
        
       ?>
<?= Former::close() ?>
                
                
                <?php
                //Error message if the student number doesn't exist.
                if(isset($_SESSION['compareUsers']))
                {
                    if($_SESSION['compareUsers'] === false)
                    {
                        echo '<div class="alert alert-danger">The student number does not exist.</div>';
                    }
                }
                
                //Error message for comparing passwords.
                if(isset($_SESSION['comparePasswords']))
                {
                    if($_SESSION['comparePasswords'] === false)
                    {
                        echo '<div class="alert alert-danger">The entered passwords did not match. Please try again.</div>';
                    }
                }
                
                // Check if the email is not valid, then display an error
                if ( isset($_SESSION['isValidEmail']) ) 
                {
                    if ( $_SESSION['isValidEmail'] === false)
                    {
                        echo '<div class="alert alert-danger">The entered email is invalid.</div>';
                    }
                }
                
                $isValidAge = false;
                if ( isset($_SESSION['isValidAge']) ) 
                {
                    if ( $_SESSION['isValidAge'] === true )
                    {
                        $isValidAge = true;
                    }
                    else
                    {
                        echo '<div class="alert alert-danger">The age entered is invalid.</div>';
                    }
                }
                
                if( isset( $_SESSION['compareUsers']) && $_SESSION['compareUsers'] && isset($_SESSION['comparePasswords']) 
                        && $_SESSION['comparePasswords'] && isset($_SESSION['isValidEmail']) && $_SESSION['isValidEmail'] && $isValidAge )
                {
                    //Inserting a student
                    \App\Http\Controllers\StudentInfoController::insertStudent("");
                }
                
                
                
                ?>
                
                
                </div>
            </div>
         </div>
    </div>

@endsection


