# Algoritma Dictionary Bundle

The **AlgoritmaDictionaryBundle** is an OroCommerce bundle designed to manage dictionaries and custom translations within the platform.

Languages supported:
- English (en)
- Italian (it_IT)

**Contribution are welcome!**

## Table of Contents

- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)
- [Contacts](#contacts)

---

## Installation

To install the bundle, you can use Composer. Since the bundle is usually hosted in a private or local repository, ensure it is correctly configured in the main project's `composer.json`.

### 1. Add the bundle via Composer

Run the following command from the project root:

```bash
composer require algoritma/oro-dictionary-bundle
```

### 2. Bundle Registration

The bundle is automatically registered via the `Resources/config/oro/bundles.yml` file. Ensure that OroCommerce correctly loads the configurations.

### 3. Update Cache and Translations

After installation, you need to clear the cache and reload the translations:

```bash
php bin/console cache:clear
php bin/console oro:translation:update --force
```

---

## Configuration

Currently, the bundle does not require additional configurations in `config/parameters.yml` or `config/config.yml`. All translations are automatically loaded by the OroCommerce translation system.

---

## Usage

The bundle provides custom translations for various scopes (entities, messages, validations, etc.) in Italian (it_IT) and English (en).

Translation files are located in `Resources/translations/`. To add new translations, create or modify the existing YAML files following the Symfony/OroCommerce naming convention.

---

## Contributing

We are happy to receive contributions! To contribute to the project, follow these steps:

1. **Fork** the repository.
2. Create a **Branch** for your feature or bugfix (`git checkout -b feature/new-feature`).
3. **Commit** your changes using clear and descriptive messages.
4. **Push** to the branch (`git push origin feature/new-feature`).
5. Open a **Pull Request**.

### Coding Standards

- Run `bin/console lint:yaml Resources/translations`
- Ensure that translations are consistent with the existing terminology in the project.

---

## License

This project is distributed under the MIT license. See the `composer.json` file for more details.

---

## Contacts

**Algoritma srl**
- Email: [commerciale@algoritma.it](mailto:commerciale@algoritma.it)
- Website: [https://www.algoritma.it](https://www.algoritma.it)
