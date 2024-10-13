import { Link } from "@inertiajs/inertia-react"
import Nav from "../Layout/Nav"

export default function Header() {
    return (
        <header className="flex top-header container mx-auto mt-4">
        <div className="logo">
          <Link href="/"><h1>Leartunity.</h1></Link>
        </div>
        <Nav />
        </header>
    )
}
