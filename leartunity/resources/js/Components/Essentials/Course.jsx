import { Link } from "@inertiajs/inertia-react"
export default function Course() {
    return (
    <div className="course">
        <div className="course-header" style={{ position: "relative" }}>
          <div
            style={{ position: "absolute", bottom: 10, right: 10 }}
            className="flex"
          >
            <button
              className="mr-2 text-white px-2 rounded bg-red-500 hover:bg-red-600"
              as="button"
            >
              Delete
            </button>
            <Link
              className="text-white px-2 rounded bg-blue-500 hover:bg-blue-600"
              as="button"
            >
            Update
            </Link>
          </div>
          <img style={{ borderRadius: 10 }} height={600} width={400} alt="" />
          <img src="https://placehold.co/600x400" height={600} width={400} alt="" />
        </div>
        <div className="course-detail mt-4">
          <div className="course-description">
            <h1 style={{ fontSize: 15, fontWeight: "bold", marginBottom: 5 }}>
              The Title
            </h1>
            The Description
          </div>
          <div className="course-options mt-2">
            <a className="m-2">Enroll</a>
            <Link className="m-2" style={{ marginRight: 5 }}>
            Open
            </Link>
            <Link className="m-2" style={{ marginRight: 5 }}>
            See More
            </Link>
            <br />
            <Link className="m-2" style={{ marginRight: 5 }}>
            Manage
            </Link>
          </div>
          <div className="course-price flex justify-between">
            <p>1</p>
            <p>No Content Yet!</p>
          </div>
        </div>
      </div>

    )
}
