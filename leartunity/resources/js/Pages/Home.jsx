import Layout from "../Layout/Layout"
import Categories from "../Components/Home/Categories"
import Course from "../Components/Essentials/Course"

export default function Home({ categories, plans, quote }) {
    return (
        <Layout>
            <main>
  <section
    id="search-area"
    className="container mx-auto"
    style={{ position: "relative" }}
  >
    <form className="inline-block">
      <select
        className="search-type highlighted p-1 mt-4"
        style={{ width: "10%", height: 35 }}
      >
        <option value="categories">Categories</option>
        <option value="course">Course</option>
        <option value="teachers">Teachers</option>
      </select>
      <input
        type="text"
        placeholder="Search for anything!"
        style={{ borderRadius: 0, border: "1px solid #424242" }}
        id="q"
        name=""
      />
      <div
        className="results"
        style={{
          overflow: "auto",
          maxHeight: 300,
          borderRadius: 5,
          border: "1px solid black",
          right: 0,
          position: "absolute",
          background: "white",
          width: "89%",
          top: "115%",
          paddingLeft: 10
        }}
      >
        <div className="teachers results py-2 flex">
          <div
            className="search_thumbnail mr-4"
          >
            <img src="lol" alt="" />
          </div>
          <p>kaka</p>
        </div>
      </div>
    </form>
  </section>
  <div>
    <div
      id="separator"
      className="container mx-auto mt-4"
      style={{ background: "black", height: 2 }}
    >
      &nbsp;
    </div>
    <section
      id="banner"
      style={{ background: "var(--primary)" }}
      className="text-center"
      contentEditable=""
    >
      <h1 id="sliders">
        { quote.quote }
      </h1>
    </section>
  </div>
  <section id="courses" className="container mx-auto">
    <h1 className="text-center">Top Courses</h1>
    <div className="tabs mt-5">
        <Categories categories={categories}/>
    </div>
    <div v-for="category in categories">
      <div className="grid grid-cols-4 gap-4">
        <Course></Course>
      </div>
    </div>
  </section>
  <section id="apply-for-teaching" className="container mx-auto flex ">
    <div className="side-image">
      <img src="./img/sample.jpg" alt="" />
    </div>
    <div className="apply">
      <h1>Become Teacher</h1>
      <p>Start teaching right away, and arrange live sessions</p>
      <div className="flex">
        <button className="mr-1">Apply</button>
        <button
          style={{
            background: "transparent",
            color: "black",
            border: "1px solid var(--primary)"
          }}
        >
          Learn More
        </button>
      </div>
    </div>
  </section>
</main>

        </Layout>
    )
}
