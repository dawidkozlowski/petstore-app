# Petstore CRUD – Symfony 7 + REST API

Minimalna aplikacja w **Symfony 7 (PHP 8.2)** komunikująca się z publicznym API [Swagger Petstore](https://petstore.swagger.io/).  
Umożliwia **dodawanie, pobieranie, edycję i usuwanie** zasobu `/pet`.  
Dodatkowo zawiera prosty interfejs użytkownika oparty o **Twig + Bootstrap**.

---

## Funkcjonalności

- [x] Dodawanie nowego `Pet`
- [x] Pobieranie `Pet` po ID
- [x] Edycja istniejącego `Pet`
- [x] Usuwanie `Pet`
- [x] Walidacja formularzy (NotBlank, required)
- [x] Obsługa błędów i flash messages
- [x] Minimalistyczne UI w Twig (Bootstrap 5)

---

## Instalacja

1. Sklonuj repozytorium:

```bash
git clone https://github.com/<twoje-repo>/petstore-app.git
cd petstore-app
