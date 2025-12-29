@extends('front.partials.app')

<style>
    .amc-course-section {
  padding: 80px 0;
      background: linear-gradient(135deg, #f8f9fc 0%, #e8f0fe 100%);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.amc-course-title {
  text-align: center;
  margin-bottom: 50px;
}

.amc-course-title h2 {
  font-size: 38px;
  font-weight: 700;
  color: #0A1D56;
  margin: 0 0 15px;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.amc-divider {
  width: 80px;
  height: 4px;
  background: #FF6B35;
  margin: 0 auto;
  border: none;
  border-radius: 2px;
}

/* Course Card */
.amc-course-card {
  background: white;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 8px 25px rgba(10, 29, 86, 0.1);
  transition: all 0.4s ease;
  margin-bottom: 30px;
  height: auto;
      display: grid;
    grid-template-columns: 2fr 10fr;
}

.amc-course-card:hover {
  transform: translateY(-12px);
  box-shadow: 0 20px 40px rgba(10, 29, 86, 0.18);
}

.amc-course-image {
    width:100%;
  height: auto;
  display:flex;
  justify-content:center;
  align-items:center;
  overflow: hidden;
}

.amc-course-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
}

.amc-course-card:hover .amc-course-image img {
  transform: scale(1.1);
}

.amc-course-content {
  padding: 25px;
  flex-grow: 1;
}

.amc-course-content h3 {
  margin: 0 0 15px;
  font-size: 20px;
  font-weight: 600;
  color: #0A1D56;
  line-height: 1.4;
}

.amc-course-content h3 a {
  color: inherit;
  text-decoration: none;
  transition: color 0.3s;
}

.amc-course-content h3 a:hover {
  color: #FF6B35;
}

.amc-course-content p {
  color: #555;
  font-size: 15px;
  line-height: 1.6;
  margin: 0;
}

.amc-course-footer {
  padding: 0 25px 25px;
}

.amc-read-more-btn {
  display: inline-block;
  background: #FF6B35;
  color: white;
  padding: 12px 28px;
  border-radius: 50px;
  font-weight: 600;
  text-decoration: none;
  font-size: 15px;
  transition: all 0.3s ease;
  box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
}

.amc-read-more-btn:hover {
  background: #e55a30;
  transform: translateY(-3px);
  box-shadow: 0 10px 25px rgba(255, 107, 53, 0.4);
  color: white;
}

.amc-read-more-btn i {
  margin-left: 8px;
  font-size: 14px;
}

</style>
@section('content')

<!--------------------------Our Courses Start------------------------------>
<div class="about-banner mb-5">
	<!--<img src="images/our-courses.jpg" class="img-responsive"/>-->
</div>
<div class="about-title">
	
</div>
<div class="amc-course-section">
  <div class="amc-course-title " style="margin-top:50px;">
    <h2>Programmes</h2>
    <hr class="amc-divider">
  </div>

  
  <div class="container ">
  <div class="row">

    <!-- Static Card 1 -->
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="amc-course-card">
        <div class="amc-course-image col-3">
          <img src="{{ asset('images/computer-training.jpeg') }}" alt="Diploma in Functional Arabic" class="img-responsive">
        </div>
        <div class="amc-course-content col-7">
          <h3><a href="">Computer Training Program </a></h3>
          <p>Computers have become essential in today's world. Computer technology is used across nearly every industry, and computer literacy significantly improves employment opportunities. Our mission is to spread computer education as widely as possible. We offer various computer training programs, including diploma courses in Professional DTP, CCC, Office Automation, Tally, Graphic Design, and others like CorelDraw, Photoshop, Hardware, and MS Office. We train students to face competitive environments and become self-sufficient. Every financial year, we select 30 deserving youth from underprivileged backgrounds to receive three months of software training. The curriculum includes Computer Fundamentals, MS Office, DTP, Internet Concepts, and Soft Skills. </p>
        </div>
        
      </div>
    </div>

    <!-- Static Card 2 -->
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="amc-course-card">
        <div class="amc-course-image">
          <img src="{{ asset('images/graphics.jpeg') }}" alt="Diploma in Urdu Language" class="img-responsive">
        </div>
        <div class="amc-course-content">
          <h3><a href="">Calligraphy and Graphic Design training </a></h3>
          <p>AMC runs a Calligraphy and Graphic Design Course financial acceptance by the National Council Promotion for the Urdu Language
Calligraphy is the art of beautiful handwriting, created by hand using flat calligraphy pens. It encompasses a wide variety of writing styles that require patience, practice, and perseverance to master.   it has been offering comprehensive classes for both male and female students. In addition to regular training sessions, the center also hosts workshops focused on traditional calligraphy techniques applied to materials such as pottery, glass, and more.  
This course is perfect for anyone passionate about combining artistic expression with cultural heritage through the timeless beauty of calligraphy. </p>
        </div>
       
      </div>
    </div>

    <!-- Static Card 3 -->
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="amc-course-card">
        <div class="amc-course-image">
          <img src="{{ asset('images/logo1.jpg') }}" alt="Diploma in Fashion Designing" class="img-responsive">
        </div>
        <div class="amc-course-content">
          <h3><a href="">Urdu and Arabic Diploma Course</a></h3>
          <p>we offer One year diploma in Urdu language, and Two years “Diploma in Functional Arabic “ [financially assisted by National Council for promotion of Urdu Language, Ministry of Human resources Development, government of India. </p>
        </div>
       
      </div>
    </div>

    <!-- Static Card 4 -->
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="amc-course-card">
        <div class="amc-course-image">
          <img src="{{ asset('images/logo1.jpg') }}" alt="Computer Courses" class="img-responsive">
        </div>
        <div class="amc-course-content">
          <h3><a href="">Road Safety Program </a></h3>
          <p>Transportation is a vital part of life but comes with risks if road safety education is lacking. To promote awareness, AMC conducts workshops to educate the public on traffic rules and the staggering statistics of road accidents. 
Mr. Mohsin Khan stated, "Let us not become our own enemies on the road but work together to develop our knowledge and attitude as our road infrastructure improves." He added, "It's our duty to reduce road casualties as much as possible."  This program attracts hundreds of participants, including young children who also participate in a drawing competition. Prizes are awarded, and a book on traffic rules is distributed.  
</p>
        </div>
        
      </div>
    </div>
    
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="amc-course-card">
        <div class="amc-course-image">
          <img src="{{ asset('images/logo1.jpg') }}" alt="Computer Courses" class="img-responsive">
        </div>
        <div class="amc-course-content">
          <h3><a href="">Hygiene and Sanitation </a></h3>
          <p>Clean drinking water, hygiene, and sanitation are vital for health. AMC organized camps in the slum areas of Old Lucknow and Malihabad to raise awareness about waterborne diseases like diarrhea caused by contaminated water. The program emphasized health and hygiene education to contribute to social and economic. 
</p>
        </div>
        
      </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="amc-course-card">
        <div class="amc-course-image">
          <img src="{{ asset('images/logo1.jpg') }}" alt="Computer Courses" class="img-responsive">
        </div>
        <div class="amc-course-content">
          <h3><a href="">Seminar - Urdu Ek Bhuli Si Dastaan </a></h3>
          <p>In collaboration with Aadaab Arz Lucknow, AMC hosted a tribute to legendary poet Jaun Elia. The event promoted the importance of reviving Urdu in daily use. Syed Shoeb, former chairman of the Waqf Board, said, "Urdu must be used in everyday life to protect it." Dr. Sabra Habib emphasized that Urdu, once a global language, should not be associated with a single community. — also attended the program. A calligraphy exhibition by students added depth to the event. The seminar highlighted Urdu's universal relevance and the need to preserve its cultural heritage. 
</p>
        </div>
        
      </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="amc-course-card">
        <div class="amc-course-image">
          <img src="{{ asset('images/logo1.jpg') }}" alt="Computer Courses" class="img-responsive">
        </div>
        <div class="amc-course-content">
          <h3><a href="">International Yoga Day  </a></h3>
          <p>Celebrated enthusiastically by AMC students and staff, the event began with warm-up exercises, followed by sitting and standing asanas. The importance of each posture was explained. Mr. Ashish Shukla encouraged regular yoga for improved physical, mental, and spiritual well-being.   
</p>
        </div>
        
      </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="amc-course-card">
        <div class="amc-course-image">
          <img src="{{ asset('images/logo1.jpg') }}" alt="Computer Courses" class="img-responsive">
        </div>
        <div class="amc-course-content">
          <h3><a href="">Art and Craft Workshop </a></h3>
          <p>AMC regularly organizes art exhibitions and competitions to discover and promote student creativity. Both internal and external participants display work in forms such as pictorial, decorative, and performing arts. We run a handicraft training center at our registered office, offering skills like making jute bags, wall hangings, baskets, and chikan embroidery. This training helps artisans earn livelihoods and gain recognition. 
</p>
        </div>
        
      </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="amc-course-card">
        <div class="amc-course-image">
          <img src="{{ asset('images/logo1.jpg') }}" alt="Computer Courses" class="img-responsive">
        </div>
        <div class="amc-course-content">
          <h3><a href="">Skill Training for Minorities </a></h3>
          <p>With increasing competition and declining job opportunities, many youth experience frustration. Women, in particular, often lack access to education and work, making them dependent.  AMC provides vocational training in stitching, embroidery (including zardozi), and other craft skills. This initiative empowers women with sustainable employmer mproves their economic conditions and  enhances their quality of living.  
</p>
        </div>
        
      </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="amc-course-card">
        <div class="amc-course-image">
          <img src="{{ asset('images/logo1.jpg') }}" alt="Computer Courses" class="img-responsive">
        </div>
        <div class="amc-course-content">
          <h3><a href="">Consumer Awareness Program </a></h3>
          <p>AMC launched a campaign to raise awareness about consumer rights. With an overwhelming number of products on the market, many consumers fall victim to malpractices. Our campaign emphasized the right to ask questions, compare options, and demand accountability. We encouraged people to speak out against fraud and demand fair value for their money.
</p>
        </div>
        
      </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="amc-course-card">
        <div class="amc-course-image">
          <img src="{{ asset('images/logo1.jpg') }}" alt="Computer Courses" class="img-responsive">
        </div>
        <div class="amc-course-content">
          <h3><a href="">Women Entrepreneurship </a></h3>
          <p>Our Livelihoods & Craft Entrepreneurship Program trains economically weaker women in handicrafts, calligraphy, and art to help them establish small businesses. At the Mahindra Sanatkada Jashn Festival in Lucknow, AMC showcased a Calligraphy Stall featuring handmade crafts and live name inscriptions. This initiative promoted traditional art forms and underscored AMC's commitment to culture and community engagement.    
</p>
        </div>
        
      </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="amc-course-card">
        <div class="amc-course-image">
          <img src="{{ asset('images/logo1.jpg') }}" alt="Computer Courses" class="img-responsive">
        </div>
        <div class="amc-course-content">
          <h3><a href="">Swachh Bharat Campaign  </a></h3>
          <p>On October 2, AMC organized a Cleanliness Awareness Campaign in Qaiserbagh, Lucknow, under the Swachh Bharat Mission. The campaign, titled "Make My India Clean," involved students and staff working together to clean public spaces. This event paid tribute to Mahatma Gandhi and emphasized the importance of cleanliness. 
</p>
        </div>
        
      </div>
    </div>
    
     <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="amc-course-card">
        <div class="amc-course-image">
          <img src="{{ asset('images/logo1.jpg') }}" alt="Computer Courses" class="img-responsive">
        </div>
        <div class="amc-course-content">
          <h3><a href="">Cultural Program   </a></h3>
          <p>On December 15, AMC organized "Shame Afsana," an evening of Urdu storytelling in collaboration with Bazm-e-Urdu. The event featured moving stories, a calligraphy competition, and an exploration of Urdu's literary richness. The event reinforced AMC's dedication to preserving cultural heritage.
</p>
        </div>
        
      </div>
    </div>
    
     <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="amc-course-card">
        <div class="amc-course-image">
          <img src="{{ asset('images/logo1.jpg') }}" alt="Computer Courses" class="img-responsive">
        </div>
        <div class="amc-course-content">
          <h3><a href="">Republic Day </a></h3>
          <p>On January 26, AMC celebrated Republic Day with a flag-hoisting ceremony, the singing of the national anthem, speeches, and cultural performances. The Principal emphasized the importance of sports and student involvement. The celebration concluded with the distribution of sweets. 
</p>
        </div>
        
      </div>
    </div>
    
     <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="amc-course-card">
        <div class="amc-course-image">
          <img src="{{ asset('images/logo1.jpg') }}" alt="Computer Courses" class="img-responsive">
        </div>
        <div class="amc-course-content">
          <h3><a href="">Air Pollution Awareness Program  </a></h3>
          <p>On February 8, AMC held a program to raise awareness about air pollution, including a graphic design competition. Speakers like Mrs. Sumbul Khan and Mr. Vadudul Hasan Usmani emphasized urgent environmental action. Young participants presented compelling artwork on pollution and sustainability. The exhibition served as both education and inspiration. 
</p>
        </div>
        
      </div>
    </div>
    
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="amc-course-card">
        <div class="amc-course-image">
          <img src="{{ asset('images/logo1.jpg') }}" alt="Computer Courses" class="img-responsive">
        </div>
        <div class="amc-course-content">
          <h3><a href="">Women Empowerment Program  </a></h3>
          <p>On March 21, AMC hosted a session to empower young women to understand their rights, recognize their potential, and strive for independence. The event featured interactive discussions on education, self-belief, and personal growth. Participants shared experiences in a supportive and motivating environment.
 
</p>
        </div>
        
      </div>
    </div>
    

  </div>

  <!-- View All Button -->
  <!--<div class="amc-view-all text-center" style="margin-top: 40px;">-->
  <!--  <a href="courses.php" class="amc-view-all-btn">-->
  <!--    <strong>View All Courses</strong>-->
  <!--  </a>-->
  <!--</div>-->
</div>
</div>

<!--------------------------Our Courses End------------------------------>

@endsection