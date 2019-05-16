<template>
  <div>
    <!--====== COURSES SINGEl PART START ======-->
    <section id="corses-singel" class="pt-10 pb-20 gray-bg">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <div class="corses-singel-left mt-30">
              <div class="title">
                <h3>ສະຖາບັນການເງິນ-ການທະນາຄານ</h3>
              </div>
              <!-- title -->
              <div class="course-terms">
                <ul>
                  <li>
                    <div class="course-category">
                      <div class="name">
                        <span>Published</span>
                        <h6>22 May,2019</h6>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="course-category">
                      <span>ໝວດໝູ່ສະຖານການສຶກສາ</span>
                      <h6>ພາກລັດ</h6>
                    </div>
                  </li>
                  <li>
                    <div class="course-category">
                      <span>ວັນສ້າງຕັ້ງ</span>
                      <h6>22.5.2009</h6>
                    </div>
                  </li>
                </ul>
              </div>
              <!-- course terms -->
              <div class="corses-singel-image pt-50">
                <img :src="`${baseUrl}${baseRes}/assets/images/course/cu-1.jpg`" alt="Courses">
              </div>
              <!-- corses singel image -->
              <div class="corses-tab mt-30">
                <ul class="nav nav-justified" id="myTab" role="tablist">
                  <li class="nav-item institute">
                    <a
                      class="active"
                      id="overview-tab"
                      data-toggle="tab"
                      href="#overview"
                      role="tab"
                      aria-controls="overview"
                      aria-selected="true"
                    >ລາຍລະອຽດກ່ຽວກັບສະຖານການສຶກສາ</a>
                  </li>
                  <!-- <li class="nav-item">
                    <a
                      id="curriculam-tab"
                      data-toggle="tab"
                      href="#curriculam"
                      role="tab"
                      aria-controls="curriculam"
                      aria-selected="false"
                    >ຫຼັດສູດການສຶກສາ</a>
                  </li>
                  <li class="nav-item">
                    <a
                      id="instructor-tab"
                      data-toggle="tab"
                      href="#instructor"
                      role="tab"
                      aria-controls="instructor"
                      aria-selected="false"
                    >ຂໍ້ມູນຕິດຕໍ່</a>
                  </li>-->
                </ul>
                <div class="tab-content" id="myTabContent">
                  <div
                    class="tab-pane fade show active"
                    id="overview"
                    role="tabpanel"
                    aria-labelledby="overview-tab"
                  >
                    <div class="overview-description">
                      <div class="singel-description pt-40">
                        <h6>ກ່ຽວກັບສະຖາບັນ</h6>
                        <p>Lorem ipsum gravida nibh vel velit auctor aliquetn sollicitudirem quibibendum auci elit cons equat ipsutis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus .</p>
                      </div>
                      <div class="singel-description pt-40">
                        <h6>ຫຼັດສູດການສຶກສາ</h6>
                        <p>Lorem ipsum gravida nibh vel velit auctor aliquetn sollicitudirem quibibendum auci elit cons equat ipsutis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus .</p>
                      </div>
                    </div>
                    <!-- overview description -->
                  </div>
                </div>
                <!-- tab content -->
              </div>
              <div>
                <ul class="share">
                  <li class="title">Share :</li>
                  <li>
                    <a target="_blank" href="#">
                      <i class="fab fa-facebook-f"></i>
                    </a>
                  </li>
                  <li>
                    <a target="_blank" href="#">
                      <i class="fab fa-twitter"></i>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <!-- corses singel left -->
          </div>
          <div class="col-lg-4">
            <div class="row">
              <div class="col-lg-12 col-md-6">
                <div class="course-features mt-30">
                  <h4>ຂໍ້ມູນຕິດຕໍ່</h4>
                  <ul>
                    <li>
                      <div class="icon">
                        <i class="fa fa-phone"></i>
                      </div>
                      <div class="cont">
                        <p>020 50454544</p>
                      </div>
                    </li>
                    <li>
                      <div class="icon">
                        <i class="far fa-envelope"></i>
                      </div>
                      <div class="cont">
                        <p>example@gmail.com</p>
                      </div>
                    </li>
                    <li>
                      <div class="icon">
                        <i class="fa fa-home"></i>
                      </div>
                      <div class="cont">
                        <p>Address</p>
                      </div>
                    </li>
                    <li>
                      <div class="icon">
                        <i class="fas fa-globe"></i>
                      </div>
                      <div class="cont">
                        <p>www.google.com</p>
                      </div>
                    </li>
                    <li></li>
                  </ul>
                  <div>
                    <ul class="share social">
                      <li class="title">Social :</li>
                      <li>
                        <a target="_blank" href="#">
                          <i class="fab fa-facebook-f"></i>
                        </a>
                      </li>
                      <li>
                        <a target="_blank" href="#">
                          <i class="fab fa-twitter"></i>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
                <!-- course features -->
              </div>
              <div class="col-lg-12 col-md-6">
                <div class="You-makelike mt-30">
                  <h4>ແຜນທີ່ສະຖານການສຶກສາ</h4>

                  <div class="gmap mt-10">
                    <iframe
                      src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15175.027535503485!2d102.6322612026245!3d18.03648292309852!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31245d38b6cb9d2b%3A0xd933c8032521d049!2z4Lqh4Lqw4Lqr4Lqy4Lqn4Lq04LqX4Lqw4LqN4Lqy4LuE4Lql4LuB4Lqr4LuI4LqH4LqK4Lqy4LqU!5e0!3m2!1slo!2sla!4v1557239144195!5m2!1slo!2sla"
                      frameborder="0"
                      scrolling="no"
                      marginheight="0"
                      marginwidth="0"
                      style="width: 100%;
                   height: 228px;"
                    ></iframe>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- row -->
        <div class="row">
          <div class="col-lg-12">
            <div class="releted-courses pt-45">
              <div class="title">
                <h3>ສະຖານການສຶກສາອື່ນໆທີ່ກຽ່ວຂ້ອງ</h3>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="singel-course mt-30">
                    <div class="thum">
                      <div class="image">
                        <img
                          :src="`${baseUrl}${baseRes}/assets/images/course/cu-2.jpg`"
                          alt="Course"
                        >
                      </div>
                    </div>
                    <div class="cont institute">
                      <a href="courses-singel.html">
                        <h4>ສະຖາບັນຂົງຈື້</h4>
                      </a>
                      <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. In aliquid provident nesciunt inventore ipsa odit quisquam repellat praesentium?</p>
                      <div class="course-teacher">
                        <div class="name-course">
                          <a href="#">
                            <h6>
                              <i class="fa fa-tags"></i> ມະຫາວິທະຍາໄລແຫ່ງຊາດ
                            </h6>
                          </a>
                        </div>
                        <div>
                          <ul>
                            <li>
                              <span>Updated 22/4/2019</span>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- singel course -->
                </div>
                <div class="col-md-4">
                  <div class="singel-course mt-30">
                    <div class="thum">
                      <div class="image">
                        <img
                          :src="`${baseUrl}${baseRes}/assets/images/course/cu-1.jpg`"
                          alt="Course"
                        >
                      </div>
                    </div>
                    <div class="cont institute">
                      <a href="courses-singel.html">
                        <h4>ສະຖາບັນລາວ-ເກົາຫຼີ</h4>
                      </a>
                      <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. In aliquid provident nesciunt inventore ipsa odit quisquam repellat praesentium?</p>
                      <div class="course-teacher">
                        <div class="name-course">
                          <a href="#">
                            <h6>
                              <i class="fa fa-tags"></i> ມະຫາວິທະຍາໄລແຫ່ງຊາດ
                            </h6>
                          </a>
                        </div>
                        <div>
                          <ul>
                            <li>
                              <span>Updated 22/4/2019</span>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- singel course -->
                </div>
                <div class="col-md-4">
                  <div class="singel-course mt-30">
                    <div class="thum">
                      <div class="image">
                        <img
                          :src="`${baseUrl}${baseRes}/assets/images/course/cu-1.jpg`"
                          alt="Course"
                        >
                      </div>
                    </div>
                    <div class="cont institute">
                      <a href="courses-singel.html">
                        <h4>ສະຖາບັນລາວ-ເກົາຫຼີ</h4>
                      </a>
                      <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. In aliquid provident nesciunt inventore ipsa odit quisquam repellat praesentium?</p>
                      <div class="course-teacher">
                        <div class="name-course">
                          <a href="#">
                            <h6>
                              <i class="fa fa-tags"></i> ມະຫາວິທະຍາໄລແຫ່ງຊາດ
                            </h6>
                          </a>
                        </div>
                        <div>
                          <ul>
                            <li>
                              <span>Updated 22/4/2019</span>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- singel course -->
                </div>
              </div>
              <!-- row -->
            </div>
            <!-- releted courses -->
          </div>
        </div>
        <!-- row -->
      </div>
      <!-- container -->
    </section>
    <!--====== COURSES SINGEl PART ENDS ======-->
  </div>
</template>
<script>
export default {
  data: {}
};
</script>

