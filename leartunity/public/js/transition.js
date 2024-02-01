function changeTab(tabNumber) {
    // Remove active class from all tab contents
    document.querySelectorAll('.tab').forEach(tab => {
      tab.classList.remove('active');
    });

    // Add active class to the selected tab content
    const tab = document.getElementById('tab' + tabNumber);
    tab.classList.add('active');
    const tabData = tab.dataset.tab; 
    
    const courses = document.querySelectorAll(".courses");
    
    courses.forEach(course => {
      course.classList.add("none");
      course.style.display = "none";
    })

    const tabCourse = document.querySelector(`[data-content="${tabData}"]`);
    tabCourse.classList.remove("none");
    tabCourse.style.display = "grid";
  }