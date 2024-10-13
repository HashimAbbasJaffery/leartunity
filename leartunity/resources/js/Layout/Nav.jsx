import { Link } from "@inertiajs/inertia-react";
import { useState } from "react";



export default function Nav() {

    const [ appearence, setAppearence ] = useState(false);

    return (
        <>
        <nav>
  <ul style={{ position: "relative", height: 36 }}>
    <li>
      <select name="" id="listValue" className="px-2">
        <option v-for="locale in locales">USD</option>
      </select>
    </li>
    <li v-if="isAdmin">
      <Link href="/admin" />
      Admin
    </li>
    <li className="mx-3">
      <Link href="/learn" />
      Learning
    </li>
    <li className="mx-3">
      <Link href="/courses" />
      Courses
    </li>
    <li className="mx-3" v-if="isTeacher && isUser">
      <Link href="/instructor" />
      Instructor
    </li>
    <li className="mx-3 highlighted" v-if="user">
      <Link />
      Hashim Abbas
    </li>
    {/* <li className="mx-3" v-if="isGuest">
      <Link href="/register" />
      Register
    </li>
    <li className="mx-3 highlighted" v-if="isGuest">
      <Link href="/login" />
      Login
    </li> */}
    <ul className="notification-drop" style={{ position: "relative" }}>
      <li className="item">
        <i
          className="fa fa-bell-o notification-bell"
          style={{ fontSize: 20 }}
          aria-hidden="true"
        />
        <div
          className="notify"
          style={{
            top: 8,
            right: 8,
            position: "absolute",
            background: "#00ff00",
            width: 15,
            height: 15,
            borderRadius: 50,
            border: "3px solid white"
          }}
        >
          &nbsp;
        </div>
        <ul
          className="rounded"
          style={{
            maxHeight: 300,
            overflow: "auto",
            border: "1px solid var(--primary)",
          }}
        >
          <li style={{ fontSize: 12 }} className="px-1">
            "No notifications? Maybe they're at a disco party!"🎉
          </li>
        </ul>
      </li>
    </ul>
    <li>
      <Link
        style={{ fontSize: 20 }}
        className="bold-600 text-xl"
        href="/logout"
      />
      <i className="fa-solid fa-power-off" />
    </li>
    <li>
      <Link href="/test" />1
    </li>
  </ul>
</nav>

        </>
    )
}
