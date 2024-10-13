import Category from "./Category"

export default function Categories({ categories }) {
    return (
        <ul className="flex space-x-4">
            { categories.map(category => {
                return <Category key={category.id} category={category.category} />
            }) }
        </ul>
    )
}
