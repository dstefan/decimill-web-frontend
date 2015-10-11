(function (mod) {
    if (typeof exports == "object" && typeof module == "object") // CommonJS
        mod(require("../../lib/codemirror"));
    else if (typeof define == "function" && define.amd) // AMD
        define(["../../lib/codemirror"], mod);
    else // Plain browser env
        mod(CodeMirror);
})(function (CodeMirror) {

    "use strict";

    CodeMirror.overlayMode = function (base, overlay, combine) {
        return {
            startState: function () {
                return {
                    base: CodeMirror.startState(base),
                    overlay: CodeMirror.startState(overlay),
                    basePos: 0, baseCur: null,
                    overlayPos: 0, overlayCur: null,
                    lineSeen: null
                };
            },
            copyState: function (state) {
                return {
                    base: CodeMirror.copyState(base, state.base),
                    overlay: CodeMirror.copyState(overlay, state.overlay),
                    basePos: state.basePos, baseCur: null,
                    overlayPos: state.overlayPos, overlayCur: null
                };
            },
            token: function (stream, state) {
                if (stream.sol() || stream.string != state.lineSeen ||
                        Math.min(state.basePos, state.overlayPos) < stream.start) {
                    state.lineSeen = stream.string;
                    state.basePos = state.overlayPos = stream.start;
                }

                if (stream.start == state.basePos) {
                    state.baseCur = base.token(stream, state.base);
                    state.basePos = stream.pos;
                }
                if (stream.start == state.overlayPos) {
                    stream.pos = stream.start;
                    state.overlayCur = overlay.token(stream, state.overlay);
                    state.overlayPos = stream.pos;
                }
                stream.pos = Math.min(state.basePos, state.overlayPos);

                // state.overlay.combineTokens always takes precedence over combine,
                // unless set to null
                if (state.overlayCur == null)
                    return state.baseCur;
                else if (state.baseCur != null &&
                        state.overlay.combineTokens ||
                        combine && state.overlay.combineTokens == null)
                    return state.baseCur + " " + state.overlayCur;
                else
                    return state.overlayCur;
            },
            indent: base.indent && function (state, textAfter) {
                return base.indent(state.base, textAfter);
            },
            electricChars: base.electricChars,
            innerMode: function (state) {
                return {state: state.base, mode: base};
            },
            blankLine: function (state) {
                if (base.blankLine)
                    base.blankLine(state.base);
                if (overlay.blankLine)
                    overlay.blankLine(state.overlay);
            }
        };
    };

});

CodeMirror.defineMode("decimill", function (config, parserConfig) {

    var mustacheOverlay = {
        token: function (stream, state) {
            var ch;
            if (stream.match("`")) {
                while ((ch = stream.next()) != null) {
                    if (ch === "`") {
                        break;
                    }
                }
                return "decimill";
            }
            if (stream.match("//")) {
                while ((ch = stream.next()) != null) {
                    if (ch === "\n") {
                        break;
                    }
                }
                return "comment";
            }
            if (stream.sol() && stream.match(/(    )|\t/)) {
                console.log("block");
                while (!stream.match("//", false) && (ch = stream.next() != null)) {
                    if (ch === "\n") {
                        break;
                    }
                }
                return "decimill";
            }
            if (stream.match)
            while (stream.next() != null && !stream.match("`", false) && !stream.match(/(    )|\t/, false)) {
            }
            return null;
        }
    };
    return CodeMirror.overlayMode(CodeMirror.getMode(config, parserConfig.backdrop || "text/html"), mustacheOverlay);
});