const i18n = createI18n({
    locale: 'en',
    fallbackLocale: 'en',
    messages: {
      en: {
        message: {
          hello: 'hello world'
        }
      },
      ja: {
        message: {
          hello: 'こんにちは、世界'
        }
      }
    }
})

export default i18n;
