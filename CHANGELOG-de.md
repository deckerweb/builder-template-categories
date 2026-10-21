# Änderungsprotokoll

> Die Entwicklung endet mit 1.9.0. Falls nötig, folgen nur Sicherheitsupdates, längstens bis 31.12.2027.

## 1.9.1 — 21.10.2026

### Verbessert
- Library 1.1.0 und Updater 2.2.0 als Wartungsausnahme ergänzt, einschließlich nativer GitHub-Updates und Prüfung der Paketidentität.

### Behoben
- Abschließende Ausgabeabsicherung für Kategorienlinks und Integrationsdetails.
- Fehlende mitgelieferte Übersetzungen bei älteren installierten Sprachpaketen auch nach Sprachwechseln ergänzt.

### Sonstiges
- PHP 8.1 erforderlich; WordPress 7.0 bleibt Mindestversion.
- Funktionsentwicklung bleibt eingestellt; notwendige Sicherheitswartung endet spätestens am 31.12.2027.

## 1.9.0 — 10.10.2026

- Einheitliche Builder-Kategorien mit Herkunftshinweis; klar von WordPress-Vorlagen-Kategorien getrennt.
- Kategorie-Spalte auch nach Ersetzen der Spaltenliste durch Builder ergänzen; vorhandene Spalten und Berechtigungen bleiben erhalten.
- WordPress-Vorlagen standardmäßig im Hauptmenü mit Übersicht, Hinzufügen und Builder-Kategorien; bestehende Bearbeitungsrechte bleiben erhalten.

- Aktive Vorlagenbibliotheken mit Links und aufklappbaren Beitragstypen in der Kategorienverwaltung für berechtigte Benutzer anzeigen.

### Verbessert
- Auf die verbleibenden WordPress-Vorlagen und Builder-Bibliotheken reduziert.
- Veraltete Menüs, kleinere und fachfremde Integrationen sowie Eingriffe in andere Plugins entfernt.
- Integrationsabfragen ohne zusätzliche Datenbankabfragen.

### Behoben
- Übersetzte Beschriftungen im Block-Editor und in REST.
- Geschützter REST-Zugriff und explizite Berechtigungen für interne Kategorien.
- Sichere Behandlung ungültiger Kategorie-IDs, fehlerhafter Eingaben, fehlender Screens und Term-Fehler.
- Sichere Ausgabe von Term-Namen; keine persönlichen Daten mehr im Newsletter-Link.
- Zuverlässige Multisite-Initialisierung und Wiederherstellung des Website-Kontexts.
- Elementor Finder auf die aktuelle Registrierungsschnittstelle umgestellt.

### Sonstiges
- Mindestversionen WordPress 7.0 und PHP 8.0.
- Vorhandene Kategorien und Zuordnungen bleiben gespeichert.
- Entwicklung beendet; mögliche Sicherheitsupdates enden spätestens am 31.12.2027.

## 1.8.0 — März/April 2025

- Aktive Vorlagenbibliotheken mit Links und aufklappbaren Beitragstypen in der Kategorienverwaltung für berechtigte Benutzer anzeigen.

### Verbessert
- Plugin wieder auf die ursprüngliche, schlanke Aufgabe ausgerichtet.

### Sonstiges
- Ältere Informationslinks und die damalige Empfehlungsbibliothek entfernt.
- Vertrieb über GitHub und ZIP-Dateien.

## Ältere Versionen

Die unveränderte englische Veröffentlichungshistorie von 1.7.0 bis 1.0.0 steht im [vollständigen Changelog](CHANGELOG.md). Funktionen und Integrationen dieser historischen Versionen können mit 1.9.0 entfallen sein.
