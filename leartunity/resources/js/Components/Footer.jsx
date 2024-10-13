export default function Footer() {
    return (
        <footer>
        <div className="container mx-auto flex justify-around">
          <div className="first-column column">
            <h1>Learning Materials</h1>
            <nav>
              <ul>
                <li>Courses</li>
                <li>Books</li>
                <li>Live Sessions</li>
                <li>Teachers</li>
              </ul>
            </nav>
          </div>
          <div className="second-column column">
            <h1>Website Information</h1>
            <nav>
              <ul>
                <li>Privacy Policy</li>
                <li>Contact Us</li>
                <li>Feedbacks</li>
              </ul>
            </nav>
          </div>
          <div className="fourth-column column">
            <h1>Newsletter</h1>
            <div className="newsletter">
              <input type="text"/>
              <button>Subscribe</button>
            </div>
          </div>
          <div className="third-column column">
            <h1>Leartunity.</h1>
          </div>
        </div>
      </footer>
    )
}
