<?php

namespace Utils;

class Menu
{
    public static function displayMenu(string $title, array $options): void
    {
        self::clearScreen();
        echo " =================== $title ===================\n\n";
        foreach ($options as $index => $option) {
            echo ($index + 1) . ". $option\n";
        }
        echo "\n";
    }

    public static function getUserChoice(int $max): int
    {
        $choice = null;
        do {
            echo "Enter your choice (1-$max): ";
            $input = trim(fgets(STDIN));

            if (!is_numeric($input) || (int)$input < 1 || (int)$input > $max) {
                echo "Invalid choice! Please enter a number between 1 and $max.\n";
                continue;
            }

            $choice = (int)$input;
        } while ($choice === null);

        return $choice;
    }

    public static function clearScreen(): void
    {
        if (strncasecmp(PHP_OS, 'WIN', 3) === 0) {
            system('cls');
        } else {
            system('clear');
        }
    }

    public static function waitForEnter(): void
    {
        echo "\nPress Enter to continue...";
        fgets(STDIN);
    }
}
