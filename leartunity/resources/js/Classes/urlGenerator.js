export default class urlGenerator {
    contentUploadURL(id, isAddingContent) {
        return `/instructor/content/${id}/${isAddingContent == 1 ? 'add' : 'update'}`;
    }
}
