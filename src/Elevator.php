<?php
declare(strict_types=1);

namespace Elevator;

abstract class Camera {
    protected int $peopleCountInRoom;

    public function __construct(int $peopleCountInRoom) {
        $this->peopleCountInRoom = $peopleCountInRoom;
    }

    public function getPopleCount(): int {
        return $this->peopleCountInRoom;
    }

    abstract public function getCamera(): string;
}

class A extends Camera {
    public function getCamera(): string {
        return "A";
    }
}

class B extends Camera {
    public function getCamera(): string {
        return "B";
    }
}

class C extends Camera {
    public function getCamera(): string {
        return "C";
    }
}

class D extends Camera {
    public function getCamera(): string {
        return "D";
    }
}

class E extends Camera {
    public function getCamera(): string {
        return "E";
    }
}

class F extends Camera {
    public function getCamera(): string {
        return "F";
    }
}

class Elevator {
    private array $cameras = [];

    public function addCamera(Camera $camera): void {
        $this->cameras[] = $camera;
    }

    public function getTotalPeople(): int {
        $totalCount = 0;
        $A = null;
        $B = null;

        foreach ($this->cameras as $camera) {
            switch ($camera->getCamera()) {
                case "A":
                    $A = $camera;
                    break;
                case "B":
                    $B = $camera;
                    break;
            }
        }

        foreach ($this->cameras as $camera) {
            $type = $camera->getCamera();
            $peopleCount = $camera->getPopleCount();

            switch ($type) {
                case "B":
                    if ($A && $A->getPopleCount() >= 1) {
                        $totalCount += $peopleCount;
                    }
                    break;

                case "D":
                    if ($A && $A->getPopleCount() >= 3) {
                        $totalCount += $peopleCount;
                    }
                    break;

                case "E":
                    if ($A && $B && $A->getPopleCount() >= 1 && $B->getPopleCount() >= 2) {
                        $totalCount += $peopleCount;
                    }
                    break;

                case "F":
                    $totalCount += $peopleCount;
                    break;
            }
        }

        return $totalCount;
    }

    public function cameraData(): array {
        $details = [];
        foreach ($this->cameras as $camera) {
            $details[] = [
                'type' => $camera->getCamera(),
                'people' => $camera->getPopleCount()
            ];
        }
        return $details;
    }
}