<template>
  <div>
    <section id="courses-part" class="pt-20 pb-120 gray-bg">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="courses-top-search">
              <ul class="nav float-left" id="myTab" role="tablist">
                <li class="nav-item">
                  <span>ສະແດງ 4 ທັງໝົດ 24</span>
                </li>
                <li>
                  <div class="shop-select">
                    <select class="select form-control">
                      <option value="1">ເລືອກຕາມໜວດໝູ່</option>
                      <option value="2">ພາກລັດ</option>
                      <option value="3">ເອກະຊົນ</option>
                      <option value="4">ມະຫາວິທະຍາໄລ</option>
                    </select>
                  </div>
                  <!-- shop select -->
                </li>
              </ul>
              <!-- nav -->

              <div class="courses-search float-right">
                <form action="#">
                  <input type="text" placeholder="ຄົ້ນຫາ">
                  <button type="button">
                    <i class="fa fa-search"></i>
                  </button>
                </form>
              </div>
              <!-- courses search -->
            </div>
            <!-- courses top search -->
          </div>
        </div>
        <!-- row -->
        <div class="tab-pane fade show active" id="courses-grid" role="tabpanel">
          <div class="row">
            <div class="col-lg-4 col-md-6">
            <div class="custom-card mt-10">
              <a href="/courses/mastering-vuex/intro-to-vuex" class="grid-card card">
                <div class="media">
                  <img :src="`${baseUrl}${baseRes}/assets/images/course/cu-1.jpg`" alt="Course">
                </div>
                <div class="card-body">
                  <div class="media-block">
                    <div class="body">
                      <h3
                        class="title"
                      >Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex corrupti, error nulla hic ab eos.</h3>
                      <p class="content">
                        <i class="fas fa-fw fa-birthday-cake"></i>
                        <span>22.2.2009</span>
                      </p>
                      <p class="conent">
                        <i class="fas fa-fw fa-envelope"></i>
                        <span>info@gmail.com</span>
                      </p>
                      <p class="content">
                        <i class="fas fa-fw fa-phone"></i>
                        <span>+856 2093938384</span>
                      </p>
                    </div>
                  </div>
                  <div class="actions">
                    <div>
                      <a href="#">
                        <h6>
                          <i class="fa fa-tags"></i> ມະຫາວິທະຍາໄລແຫ່ງຊາດ
                        </h6>
                      </a>
                      <div class="button secondary border -full">View more</div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
              <!-- singel course -->
            </div>
            <div class="col-lg-4 col-md-6">
              <div class="singel-course mt-10">
                <div class="thum">
                  <div class="image">
                    <img :src="`${baseUrl}${baseRes}/assets/images/course/cu-2.jpg`" alt="Course">
                  </div>
                </div>
                <div class="cont institute">
                  <a href="courses-singel.html">
                    <h4>ວິທະຍາໄລເຕັກນິກປາກປາສັກ</h4>
                  </a>
                  <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. In aliquid provident nesciunt inventore ipsa odit quisquam repellat praesentium?</p>
                  <div class="course-teacher">
                    <div class="name-course">
                      <a href="#">
                        <h6>
                          <i class="fa fa-tags"></i> ພາກລັດ
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
            <div class="col-lg-4 col-md-6">
              <div class="singel-course mt-10">
                <div class="thum">
                  <div class="image">
                    <img :src="`${baseUrl}${baseRes}/assets/images/course/cu-3.jpg`" alt="Course">
                  </div>
                </div>
                <div class="cont institute">
                  <a href="courses-singel.html">
                    <h4>ເສດຖະສາດແລະບໍລິຫານທຸລະກິດ</h4>
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
            <div class="col-lg-4 col-md-6">
              <div class="singel-course mt-30">
                <div class="thum">
                  <div class="image">
                    <img :src="`${baseUrl}${baseRes}/assets/images/course/cu-4.jpg`" alt="Course">
                  </div>
                </div>
                <div class="cont institute">
                  <a href="courses-singel.html">
                    <h4>ເສດຖະສາດແລະບໍລິຫານທຸລະກິດ</h4>
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
            <div class="col-lg-4 col-md-6">
              <div class="singel-course mt-30">
                <div class="thum">
                  <div class="image">
                    <img :src="`${baseUrl}${baseRes}/assets/images/course/cu-5.jpg`" alt="Course">
                  </div>
                </div>
                <div class="cont institute">
                  <a href="courses-singel.html">
                    <h4>ເສດຖະສາດແລະບໍລິຫານທຸລະກິດ</h4>
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
            <div class="col-lg-4 col-md-6">
              <div class="singel-course mt-30">
                <div class="thum">
                  <div class="image">
                    <img :src="`${baseUrl}${baseRes}/assets/images/course/cu-1.jpg`" alt="Course">
                  </div>
                </div>
                <div class="cont institute">
                  <a href="courses-singel.html">
                    <h4>ເສດຖະສາດແລະບໍລິຫານທຸລະກິດ</h4>
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
        <div class="row">
          <div class="col-lg-12">
            <nav class="courses-pagination mt-50">
              <ul class="pagination justify-content-center">
                <li class="page-item">
                  <a href="#" aria-label="Previous">
                    <i class="fa fa-angle-left"></i>
                  </a>
                </li>
                <li class="page-item">
                  <a class="active" href="#">1</a>
                </li>
                <li class="page-item">
                  <a href="#">2</a>
                </li>
                <li class="page-item">
                  <a href="#">3</a>
                </li>
                <li class="page-item">
                  <a href="#" aria-label="Next">
                    <i class="fa fa-angle-right"></i>
                  </a>
                </li>
              </ul>
            </nav>
            <!-- courses pagination -->
          </div>
        </div>
        <!-- row -->
      </div>
      <!-- container -->
    </section>

    <!--====== COURSES PART ENDS ======-->
  </div>
</template>
<style scoped>
</style>

