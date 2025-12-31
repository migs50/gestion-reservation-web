public function sendResetLinkEmail(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
    ], [
        'email.required' => 'L\'adresse email est requise.',
        'email.email' => 'L\'adresse email n\'est pas valide.',
        'email.exists' => 'Aucun compte n\'existe avec cette adresse email.',
    ]);

    $status = Password::sendResetLink($request->only('email'));

    return $status === Password::RESET_LINK_SENT
        ? back()->with('status', 'Le lien de réinitialisation a été envoyé à votre adresse email.')
        : back()->withErrors(['email' => 'Impossible d\'envoyer le lien de réinitialisation.']);
}
