<?php

namespace App\Models;

/**
 * Represents an email template (static file for now: user uploaded later)
 */
class EmailTemplate
{
    public string $label;
    public string $subject;
    public string $content;

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }
    public function getContent(): string
    {
        return $this->content;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;
        return $this;
    }


    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }
}
